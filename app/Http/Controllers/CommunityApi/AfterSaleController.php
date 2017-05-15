<?php

namespace App\Http\Controllers\CommunityApi;

use App\Exceptions\ApiException;
use App\Models\AfterSale;
use App\Models\Goods;
use App\Models\Order;
use App\Models\OrderGoods;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper\CommonHelper;
use App\Helper\ResponseJson;

class AfterSaleController extends Controller
{
    /**
     * 申请退货列表
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function backOrderList(Request $request) {
        $me = $request->user();
        $memberId = $me->id;
        $orderId = intval($request->input('order_id'));

        $order = Order::whereId($orderId)->whereMemberId($memberId)->first();
        if (!$order) {
            return ResponseJson::getInstance()->errorJson('订单不存在');
        }
        $orderGoods = OrderGoods::whereOrderId($order->id)->get();
        foreach ($orderGoods as $key => $value) {
            $orderGoods[$key]['goods_price'] = CommonHelper::getInstance()->formatPriceToShow($value['goods_price']);
            $orderGoods[$key]['thumb'] = Goods::getInstance()->getGoodsSkuThumb($value['sku_id']);
            if($value['goods_number'] - $value['back_goods_number'] < 1){
                unset($orderGoods[$key]);
            }
        }
        return ResponseJson::getInstance()->doneJson('获取成功', $orderGoods);
    }

    /**
     * 申请返修列表
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function repairOrderList(Request $request) {
        $me = $request->user();
        $memberId = $me->id;
        $orderId = intval($request->input('order_id'));

        $order = Order::whereId($orderId)->whereMemberId($memberId)->first();
        if (!$order) {
            return ResponseJson::getInstance()->errorJson('订单不存在');
        }
        $orderGoods = OrderGoods::whereOrderId($order->id)->get();
        foreach ($orderGoods as $key => $value) {
            $orderGoods[$key]['goods_price'] = CommonHelper::getInstance()->formatPriceToShow($value['goods_price']);
            $orderGoods[$key]['thumb'] = Goods::getInstance()->getGoodsSkuThumb($value['sku_id']);
            if($value['goods_number'] - $value['back_goods_number'] < 1){
                unset($orderGoods[$key]);
            }
        }
        return ResponseJson::getInstance()->doneJson('获取成功', $orderGoods);
    }

    /**
     * 可退换商品详情
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBackGoodsDetail(Request $request){
        $me = $request->user();
        $memberId = $me->id;
        $orderGoodsId = intval($request->input('id'));
        $orderGoods = OrderGoods::whereId($orderGoodsId)->first();
        if (!$orderGoods) {
            return ResponseJson::getInstance()->errorJson('商品不存在');
        }
        if (!isset($orderGoods->order) || $orderGoods->order->member_id != $memberId) {
            return ResponseJson::getInstance()->errorJson('订单不存在');
        }
        unset($orderGoods->order);
        $orderGoods['goods_price'] = CommonHelper::getInstance()->formatPriceToShow($orderGoods['goods_price']);
        $orderGoods['thumb'] = Goods::getInstance()->getGoodsSkuThumb($orderGoods['sku_id']);
        $orderGoods['goods_number'] -= $orderGoods['back_goods_number']; // 实际可退货商品数量=商品数量-退货商品数量
        return ResponseJson::getInstance()->doneJson('获取成功', $orderGoods);
    }

    /**
     * 申请退货
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function backGoods(Request $request) {
        $me = $request->user();
        $memberId = $me->id;
        $orderGoodsId = intval($request->input('id'));
        $goodsNumber = intval($request->input('goods_number'));
        $question = trim($request->input('question'));
        $files = trim($request->input('pic'));

        $orderGoods = OrderGoods::whereId($orderGoodsId)->first();
        if (!$orderGoods) {
            return ResponseJson::getInstance()->errorJson('商品不存在');
        }
        if (!isset($orderGoods->order) || $orderGoods->order->member_id != $memberId) {
            return ResponseJson::getInstance()->errorJson('订单不存在');
        }
        if ($orderGoods->order->status != 4) {
            return ResponseJson::getInstance()->errorJson('只有已完成的订单才能进行此操作');
        }
        if ($goodsNumber == 0) {
            return ResponseJson::getInstance()->errorJson('退货数量不能为空');
        }
        if ($goodsNumber > ($orderGoods['goods_number'] - $orderGoods['back_goods_number'])) {
            return ResponseJson::getInstance()->errorJson('退货数量不能超过'.($orderGoods['goods_number'] - $orderGoods['back_goods_number']));
        }
        if (empty($question)) {
            return ResponseJson::getInstance()->errorJson('请填写退货原因');
        }
        if (!$files || count($files) == 0) {
            return ResponseJson::getInstance()->errorJson('请上传图片');
        }

        $pic = explode(',', $files);
        \DB::beginTransaction();
        try {
            AfterSale::create([
                'member_id' => $memberId,
                'order_id' => $orderGoods['order_id'],
                'order_goods_id' => $orderGoods['id'],
                'goods_number' => $goodsNumber,
                'type' => 1,
                'service_number' => AfterSale::getInstance()->getServiceNumber(),
                'question' => $question,
                'pic' => json_encode($pic),
                'apply_time' => time(),
                'status' => 1,
                'status_note' => '等待审核',
                'admin_id' => 0,
            ]);
            Order::whereId($orderGoods->order->id)->update([
                'is_back_goods' => 1,
            ]);
            $orderGoods->back_goods_number += $goodsNumber;
            $orderGoods->save();
            \DB::commit();
            return ResponseJson::getInstance()->doneJson('提交申请成功');
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new ApiException($e);
        }

    }

    public function getRepairGoods(Request $request){
        $me = $request->user();
        $memberId = $me->id;
        $orderGoodsId = intval($request->input('id'));
        $orderGoods = OrderGoods::whereId($orderGoodsId)->first();
        if (!$orderGoods) {
            return ResponseJson::getInstance()->errorJson('商品不存在', $orderGoods);
        }
        if (!isset($orderGoods->order) || $orderGoods->order->member_id != $memberId) {
            return ResponseJson::getInstance()->errorJson('订单不存在', $orderGoods);
        }
        unset($orderGoods->order);
        $orderGoods['goods_price'] = CommonHelper::getInstance()->formatPriceToShow($orderGoods['goods_price']);
        $orderGoods['thumb'] = Goods::getInstance()->getGoodsSkuThumb($orderGoods['sku_id']);
        $orderGoods['goods_number'] -= $orderGoods['back_goods_number']; // 实际可返修商品数量=商品数量-退货商品数量
        return ResponseJson::getInstance()->doneJson('获取成功', $orderGoods);
    }

    /**
     * 申请返修
     *
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function repairGoods(Request $request) {
        $me = $request->user();
        $memberId = $me->id;
        $orderGoodsId = intval($request->input('id'));
        $goodsNumber = intval($request->input('goods_number'));
        $question = trim($request->input('question'));
        $files = trim($request->input('pic'));

        $orderGoods = OrderGoods::whereId($orderGoodsId)->first();
        if (!$orderGoods) {
            return ResponseJson::getInstance()->errorJson('商品不存在');
        }
        if (!isset($orderGoods->order) || $orderGoods->order->member_id != $memberId) {
            return ResponseJson::getInstance()->errorJson('订单不存在');
        }
        if ($orderGoods->order->status != 4) {
            return ResponseJson::getInstance()->errorJson('只有已完成的订单才能进行此操作');
        }
        if (AfterSale::whereOrderGoodsId($orderGoods->id)->whereType(2)->whereIn('status', [1, 2, 4])->exists()) {
            return ResponseJson::getInstance()->errorJson('请等待上一个返修申请处理完毕方可进行操作');
        }
        if ($goodsNumber == 0) {
            return ResponseJson::getInstance()->errorJson('返修数量不能为空');
        }
        if ($goodsNumber > ($orderGoods['goods_number'] - $orderGoods['back_goods_number'])) {
            return ResponseJson::getInstance()->errorJson('返修数量不能超过'.($orderGoods['goods_number'] - $orderGoods['back_goods_number']));
        }
        if (empty($question)) {
            return ResponseJson::getInstance()->errorJson('请填写返修原因');
        }
        if (!$files || count($files) == 0) {
            return ResponseJson::getInstance()->errorJson('请上传图片');
        }
        $pic = explode(',', $files);
        \DB::beginTransaction();
        try {
            AfterSale::create([
                'member_id' => $memberId,
                'order_id' => $orderGoods['order_id'],
                'order_goods_id' => $orderGoods['id'],
                'goods_number' => $goodsNumber,
                'type' => 2,
                'service_number' => AfterSale::getInstance()->getServiceNumber(),
                'question' => $question,
                'pic' => json_encode($pic),
                'apply_time' => time(),
                'status' => 1,
                'status_note' => '等待审核',
                'admin_id' => 0,
            ]);
            \DB::commit();
            return ResponseJson::getInstance()->doneJson('提交申请成功');
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new ApiException($e);
        }

    }

    /**
     * 申退成功
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function backGoodsSuccess(Request $request) {
        return view('front.after_sale.back_goods_success');
    }

    /**
     * 申返成功
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function repairGoodsSuccess(Request $request) {
        return view('front.after_sale.repair_goods_success');
    }
}
