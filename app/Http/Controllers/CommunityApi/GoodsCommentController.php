<?php

namespace App\Http\Controllers\CommunityApi;

use App\Models\Goods;
use App\Models\GoodsComment;
use App\Models\Order;
use App\Models\OrderGoods;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper\CommonHelper;
use App\Helper\ResponseJson;

class GoodsCommentController extends Controller
{
    public function index(Request $request) {
        $memberId = session()->get('memberId');
        $orderId = intval($request->input('order_id'));

        $order = Order::whereId($orderId)->whereMemberId($memberId)->first();
        if (!$order) {
            abort(404, '订单不存在');
        }
        $orderGoods = OrderGoods::whereOrderId($order->id)->get();
        foreach ($orderGoods as $key => $value) {
            $orderGoods[$key]['goods_price'] = CommonHelper::getInstance()->formatPriceToShow($value['goods_price']);
            $orderGoods[$key]['thumb'] = Goods::getInstance()->getGoodsSkuThumb($value['sku_id']);
            $orderGoods[$key]['is_comment'] = GoodsComment::whereOrderGoodsId($value['id'])->exists() ? 1 : 0;
        }

        return view('front.member.order_goods', [
            'orderGoods' => $orderGoods,
        ]);
    }

    /**
     * 评价商品列表
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function goodsComment(Request $request) {
        $memberId = session()->get('memberId');
        $orderGoodsId = intval($request->input('id'));

        $orderGoods = OrderGoods::whereId($orderGoodsId)->first();
        if (!$orderGoods) {
            abort(404, '商品不存在');
        }
        if (!isset($orderGoods->order) || $orderGoods->order->member_id != $memberId) {
            abort(404, '订单不存在');
        }
        if (GoodsComment::whereOrderGoodsId($orderGoods->id)->whereMemberId($memberId)->exists()) {
            abort(404, '你已经评价过了,不能重复评价');
        }
        $orderGoods['goods_price'] = CommonHelper::getInstance()->formatPriceToShow($orderGoods['goods_price']);
        $orderGoods['thumb'] = Goods::getInstance()->getGoodsSkuThumb($orderGoods['sku_id']);
        return view('front.member.goods_comment', [
            'orderGoods' => $orderGoods,
        ]);
    }

    /**
     * 订单商品评价
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitGoodsComment(Request $request) {
        $memberId = session()->get('memberId');
        $orderGoodsId = intval($request->input('id'));
        $content = $request->input('content');

        $orderGoods = OrderGoods::whereId($orderGoodsId)->first();
        if (!$orderGoods) {
            return ResponseJson::getInstance()->errorJson('订单商品不存在');
        }
        if (!isset($orderGoods->order) || $orderGoods->order->member_id != $memberId) {
            return ResponseJson::getInstance()->errorJson('订单不存在');
        }
        if (GoodsComment::whereOrderGoodsId($orderGoods->id)->whereMemberId($memberId)->exists()) {
            return ResponseJson::getInstance()->errorJson('你已经评价过了,不能重复评价');
        }
        if (strlen($content) == 0 || strlen($content) > 150) {
            return ResponseJson::getInstance()->errorJson('评论字数限于150字以内');
        }
        GoodsComment::create([
            'member_id' => $memberId,
            'order_id' => $orderGoods->order_id,
            'goods_id' => $orderGoods->goods_id,
            'content' => $content,
            'is_show' => 0,
            'create_time' => time(),
            'order_goods_id' => $orderGoods->id,
        ]);
        return ResponseJson::getInstance()->doneJson('评价成功');
    }

    public function success(Request $request) {
        $memberId = session()->get('memberId');
        $order_id = intval($request->input('order_id'));
        if (!Order::whereId($order_id)->whereMemberId($memberId)->exists()) {
            abort(404, '订单不存在');
        }
        return view('front.member.comment_success', [
            'order_id' => $order_id,
        ]);
    }
}
