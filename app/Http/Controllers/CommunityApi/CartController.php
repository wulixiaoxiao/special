<?php

namespace App\Http\Controllers\CommunityApi;

use App\Exceptions\ApiException;
use App\Models\Cart;
use App\Models\Goods;
use App\Models\GoodsSku;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper\ResponseJson;
use App\Helper\CommonHelper;

class CartController extends Controller
{
    /**
     * 购物车列表
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $memberId = $request->user()->id;
        $cartGoods = Cart::whereMemberId($memberId)->get();
        $enableCartGoods = [];
        $disabledCartGoods = [];
        foreach ($cartGoods as $key => $value) {
            $value->thumb = isset($value->goodsSku) ? Goods::getInstance()->getGoodsSkuThumb($value->goodsSku->id) : '';
            $value->selling_price = isset($value->goodsSku) ? CommonHelper::getInstance()->formatPriceToShow($value->goodsSku->selling_price) : 0;
            if (isset($value->goods) && isset($value->goodsSku)) {
                if($value->goods->is_online == 1) {
                    $enableCartGoods[] = $value;
                } else {
                    $disabledCartGoods[] = $value;
                }
            }
        }

        $carts = $cartGoods->toArray();
        return ResponseJson::getInstance()->doneJson('获取成功', $carts);
    }

    /**
     * 加入购物车
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request) {
        $memberId = $request->user()->id;
        $goodsId = intval($request->input('goods_id'));
        $skuId = intval($request->input('sku_id'));
        $goodsNumber = intval($request->input('goods_number'));
        $goods = Goods::whereId($goodsId)->first();

        if (!$goods) {
            return ResponseJson::getInstance()->errorJson('商品不存在');
        }
        if ($goods->is_online == 0) {
            return ResponseJson::getInstance()->errorJson('商品已下架');
        }

        $goodsSku = GoodsSku::whereGoodsId($goodsId)->whereId($skuId)->first();
        if (!$goodsSku) {
            return ResponseJson::getInstance()->errorJson('商品规格不存在');
        }
        if ($goodsNumber <= 0) {
            return ResponseJson::getInstance()->errorJson('购买数量不能为空');
        }

        if ($goodsNumber > $goodsSku->stock) {
            return ResponseJson::getInstance()->errorJson('库存不足');
        }
        $cartGoods = Cart::whereMemberId($memberId)->whereGoodsId($goods->id)->whereSkuId($goodsSku->id)->first();

        if (!$cartGoods) {
            $cartGoods = Cart::create([
                'member_id' => $memberId,
                'goods_id' => $goods->id,
                'goods_number' => $goodsNumber,
                'sku_id' => $goodsSku->id,
                'create_time' => time(),
            ]);
        } else {
            if ($cartGoods->goods_number + $goodsNumber > $goodsSku->stock) {
                return ResponseJson::getInstance()->errorJson('库存不足，你的购物车已有'.$cartGoods->goods_number.'件该商品');
            }
            $cartGoods->goods_number += $goodsNumber;
            $cartGoods->save();
        }
        return ResponseJson::getInstance()->doneJson('添加购物车成功',$cartGoods->id);
    }

    /**
     * 删除购物车商品
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete(Request $request) {
        $memberId = $request->user()->id;
        $ids = trim($request->input('ids'));
        if (empty($ids)) {
            return ResponseJson::getInstance()->errorJson('请选择要删除的商品');
        }
        $ids = array_filter(explode(',', $ids));
        Cart::whereMemberId($memberId)->whereIn('id', $ids)->delete();
        return ResponseJson::getInstance()->doneJson('删除购物车商品成功');
    }

    /**
     * 增减购物车商品购买数量
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeGoodsNumber(Request $request) {
        $memberId = $request->user()->id;
        $cartId = intval($request->input('id'));
        $goodsNumber = intval($request->input('goods_number'));

        $cartGoods = Cart::whereMemberId($memberId)->whereId($cartId)->first();
        if (!$cartGoods) {
            return ResponseJson::getInstance()->errorJson('商品不存在');
        }
        if ($goodsNumber <= 0) {
            return ResponseJson::getInstance()->errorJson('购买数量不能为空');
        }
        if (!isset($cartGoods->goodsSku)) {
            return ResponseJson::getInstance()->errorJson('商品规格不存在');
        }
        if ($goodsNumber > $cartGoods->goodsSku->stock) {
            return ResponseJson::getInstance()->errorJson('库存不足');
        }
        $cartGoods->goods_number = $goodsNumber;
        $cartGoods->save();
        return ResponseJson::getInstance()->doneJson('修改成功');
    }

    /**
     * 清空购物车无效商品
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteDisabledCartGoods(Request $request) {
        $memberId = session()->get('memberId');
        $cartGoods = Cart::whereMemberId($memberId)->get();
        \DB::beginTransaction();
        try {
            foreach ($cartGoods as $key => $value) {
                if (!isset($value->goods) || !isset($value->goodsSku) || $value->goods->is_online == 0) {
                    $value->delete();
                }
            }
            \DB::commit();
            return ResponseJson::getInstance()->doneJson('清空无效商品成功');
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new ApiException($e);
        }
    }
}
