<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ApiException;
use App\Models\AdminLog;
use App\Models\Goods;
use App\Models\GoodsSku;
use App\Models\GoodsSkuSet;
use App\Models\Sku;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper\ResponseJson;

class GoodsSkuSetController extends Controller
{
    /**
     * 关联SKU首页
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $goodsId = intval($request->input('goods_id'));
        $goods = Goods::whereId($goodsId)->first();
        $skus = Sku::get();
        $skuIds = $goods->sku->pluck('id')->toArray();
        $skuNames = $goods->sku->pluck('sku_name')->toArray();
        if (!empty($skuNames)) {
            $skuNames = implode(',', $skuNames);
        } else {
            $skuNames = '';
        }
        return view('admin.goods_sku_set.index', [
            'goods' => $goods,
            'skus' => $skus,
            'skuIds' => $skuIds,
            'skuNames' => $skuNames,
        ]);
    }

    /**
     * 解除或增加SKU关联
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function chooseSku(Request $request) {
        $goodsId = intval($request->input('goods_id'));
        $skuId = intval($request->input('sku_id'));
        $type = $request->input('type');
        $goods = Goods::whereId($goodsId)->first();
        $sku = Sku::whereId($skuId)->first();
        if (!$goods) {
            return ResponseJson::getInstance()->errorJson('商品不存在');
        }
        if (!$sku) {
            return ResponseJson::getInstance()->errorJson('SKU不存在');
        }
        if (empty($type) || !in_array($type, ['add', 'del'])) {
            return ResponseJson::getInstance()->errorJson('非法操作类型');
        }
        if (GoodsSku::whereGoodsId($goods->id)->WhereRaw("FIND_IN_SET({$sku->id},sku_ids)")->exists()) {
            return ResponseJson::getInstance()->errorJson('当前SKU仍被该商品使用,请先取消该SKU的商品关联');
        }
        $goodsName = $goods->goods_name;
        $skuName = $sku->sku_name;

        \DB::beginTransaction();
        try {
            if ($type == 'add') {
                GoodsSkuSet::create([
                    'goods_id' => $goodsId,
                    'sku_id' => $skuId,
                ]);
                AdminLog::getInstance()->addLog("添加关联SKU:({$goodsName}, {$skuName})");
            } elseif ($type == 'del') {
                GoodsSkuSet::whereGoodsId($goodsId)->whereSkuId($skuId)->delete();
                AdminLog::getInstance()->addLog("删除关联SKU:({$goodsName}, {$skuName})");
            }
            \DB::commit();
            return ResponseJson::getInstance()->doneJson('操作成功');
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new ApiException($e);
        }
    }
}
