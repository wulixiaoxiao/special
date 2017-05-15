<?php

namespace App\Http\Controllers\CommunityApi;

use App\Exceptions\ApiException;
use App\Library\ExpressLibrary;
use App\Models\Cart;
use App\Models\Express;
use App\Models\Goods;
use App\Models\MemberAddress;
use App\Models\Order;
use App\Models\OrderGoods;
use App\Models\OrderLog;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper\ResponseJson;
use App\Helper\CommonHelper;

class OrderController extends Controller
{
    /**
     * 订单验证
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyOrder(Request $request) {
        $memberId = $request->user()->id;
        $cartIds = trim($request->input('cart_ids'));
        if (empty($cartIds)) {
            return ResponseJson::getInstance()->errorJson('请选择要结算的商品');
        }
        $cartIds = array_filter(explode(',', $cartIds));
        $cartIds = array_map('intval', $cartIds);
        if (Cart::whereMemberId($memberId)->whereIn('id', $cartIds)->count() == 0) {
            return ResponseJson::getInstance()->errorJson('结算商品不存在');
        }
        $cartGoods = Cart::whereMemberId($memberId)->whereIn('id', $cartIds)->get();
        foreach($cartGoods as $key => $value) {
            // 检测商品是否下架
            if ($value->goods->is_online == 0) {
                return ResponseJson::getInstance()->errorJson("{$value->goods_name}商品已下架");
            }
            // 检测规格是否存在
            if (!$value->goodsSku) {
                return ResponseJson::getInstance()->errorJson("{$value->goods_name}商品的规格不存在");
            }
            // 检测库存是否满足
            if ($value->goodsSku->stock < $value->goods_number) {
                return ResponseJson::getInstance()->errorJson("{$value->goods_name}商品的库存不足");
            }
        }
        return ResponseJson::getInstance()->doneJson('订单验证成功');
    }

    /**
     * 提交订单
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function submitOrder(Request $request) {
        $memberId = $request->user()->id;
        $cartIds = trim($request->input('cart_ids'));
        if (empty($cartIds)) {
            return ResponseJson::getInstance()->errorJson('请选择要结算的商品');
        }
        $cartIds = array_filter(explode(',', $cartIds));
        $cartIds = array_map('intval', $cartIds);
        if (Cart::whereMemberId($memberId)->whereIn('id', $cartIds)->count() == 0) {
            return ResponseJson::getInstance()->errorJson('结算商品不存在');
        }
        $cartGoods = Cart::whereMemberId($memberId)->whereIn('id', $cartIds)->get();
        foreach($cartGoods as $key => $value) {
            // 检测商品是否下架
            if ($value->goods->is_online == 0) {
                return ResponseJson::getInstance()->errorJson('商品已下架');
            }
            // 检测规格是否存在
            if (!$value->goodsSku) {
                return ResponseJson::getInstance()->errorJson('商品的规格不存在');
            }
            // 检测库存是否满足
            if ($value->goodsSku->stock < $value->goods_number) {
                return ResponseJson::getInstance()->errorJson('商品的库存不足');
            }
        }

        # 格式化价格和重量
        $cartGoodsInfo = Order::getInstance()->getCartGoodsInfo($cartGoods, $memberId);
        $cartGoodsInfo['totalGoodsWeight'] = CommonHelper::getInstance()->formatWeightToShow($cartGoodsInfo['totalGoodsWeight']);
        $cartGoodsInfo['totalGoodsPrice'] = CommonHelper::getInstance()->formatPriceToShow($cartGoodsInfo['totalGoodsPrice']);
        $cartGoodsInfo['totalOrderPrice'] = CommonHelper::getInstance()->formatPriceToShow($cartGoodsInfo['totalOrderPrice']);
//        $cartGoodsInfo['totalGoodsRebate'] = CommonHelper::getInstance()->formatPriceToShow($cartGoodsInfo['totalGoodsRebate']);
        $cartGoodsInfo['freightPrice'] = CommonHelper::getInstance()->formatPriceToShow($cartGoodsInfo['freightPrice']);

        foreach ($cartGoods as $key => $value) {
            $value['thumb'] = Goods::getInstance()->getGoodsSkuThumb($value->sku_id);
            $value['selling_price'] = CommonHelper::getInstance()->formatPriceToShow($value->goodsSku->selling_price);
        }

        $res = [
            'cartGoods' => $cartGoods,
            'cartGoodsInfo' => $cartGoodsInfo,
//            'addressList' => $this->getAddressList($request),
            'cartIds' => $request->input('cart_ids'),
        ];

       return ResponseJson::getInstance()->doneJson('成功', $res);
    }

    /**
     * 生成订单
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function doneOrder(Request $request) {
        $memberId = $request->user()->id;
        $cartIds = trim($request->input('cart_ids'));
        $addressId = intval($request->input('address_id'));
        $member = User::whereId($memberId)->first();

        if (empty($cartIds)) {
            return ResponseJson::getInstance()->errorJson('请选择要结算的商品');
        }
        $cartIds = array_filter(explode(',', $cartIds));
        $cartIds = array_map('intval', $cartIds);
        if (Cart::whereMemberId($memberId)->whereIn('id', $cartIds)->count() == 0) {
            return ResponseJson::getInstance()->errorJson('结算商品不存在');
        }
        $address = MemberAddress::getInstance()->whereId($addressId)->whereMemberId($memberId)->first();
        if (!$address) {
            return ResponseJson::getInstance()->errorJson('收货地址不存在');
        }
        $cartGoods = Cart::whereMemberId($memberId)->whereIn('id', $cartIds)->get();
        foreach($cartGoods as $key => $value) {
            // 检测商品是否下架
            if ($value->goods->is_online == 0) {
                return ResponseJson::getInstance()->errorJson("{$value->goods_name}商品已下架");
            }
            // 检测规格是否存在
            if (!$value->goodsSku) {
                return ResponseJson::getInstance()->errorJson("{$value->goods_name}商品的规格不存在");
            }
            // 检测库存是否满足
            if ($value->goodsSku->stock < $value->goods_number) {
                return ResponseJson::getInstance()->errorJson("{$value->goods_name}商品的库存不足");
            }
        }

        \DB::beginTransaction();
        try {
            $cartGoodsInfo = Order::getInstance()->getCartGoodsInfo($cartGoods, $memberId, $address->id);
            // 创建订单
            $order = Order::create([
                'member_id' => $member->id,
                'order_sn' => Order::getInstance()->getOrderSn(),
                'order_price' => $cartGoodsInfo['totalOrderPrice'],
                'goods_price' => $cartGoodsInfo['totalGoodsPrice'],
                'freight_price' => $cartGoodsInfo['freightPrice'],
                'goods_number' => $cartGoodsInfo['totalGoodsNumber'],
                'goods_weight' => $cartGoodsInfo['totalGoodsWeight'],
                'is_pay' => 0,
                'order_note' => '',
                'status' => 1,
                'is_rebate' => 0,
                'create_time' => time(),
                'receiver_name' => $address->name,
                'receiver_phone_number' => $address->phone_number,
                'receiver_province' => $address->province,
                'receiver_city' => $address->city,
                'receiver_area' => $address->area,
                'receiver_detail' => $address->detail_address,
            ]);
            // 创建订单商品,返利和粉丝奖励
            foreach ($cartGoods as $key => $value) {
                $orderGoods = OrderGoods::create([
                    'order_id' => $order->id,
                    'goods_id' => $value->goods_id,
                    'goods_price' => $value->goodsSku->selling_price,
                    'goods_number' => $value->goods_number,
                    'goods_weight' => $value->goods->goods_weight,
                    'sku_id' => $value->sku_id,
                    'sku_str' => $value->goodsSku->sku_value_ids_string,
                    'is_free_shipping' => $value->goods->is_free_shipping,
                    'goods_margin' => $value->goods->goods_margin,
                ]);
            }
            // 删除购物车
            Cart::whereMemberId($memberId)->whereIn('id', $cartIds)->delete();
            // 创建订单日志
            OrderLog::getInstance()->addLog($order->id, '创建订单:'.$member->wx_nickname.','.$order->order_sn);
            \DB::commit();
            return ResponseJson::getInstance()->doneJson('下单成功', $order->id);
        } catch (\Exception $e) {
            \DB::rollBack();
            return ResponseJson::getInstance()->errorJson($e->getMessage());
        }
    }

    /**
     * 添加收货地址
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addAddress(Request $request) {
        $me = $request->user();
        $memberId = $me->id;
        $addressId = $request->input('id', '');
        $name = trim($request->input('name'));
        $phoneNumber = trim($request->input('phone_number'));
        $province = trim($request->input('province'));
        $city = trim($request->input('city'));
        $area = trim($request->input('area'));
        $detail = trim($request->input('detail'));

        if (empty($name)) {
            return ResponseJson::getInstance()->errorJson('收货人姓名不能为空');
        }
        if (!CommonHelper::getInstance()->validatePhoneNumber($phoneNumber)) {
            return ResponseJson::getInstance()->errorJson('手机号码格式不正确');
        }
        if (empty($province)) {
            return ResponseJson::getInstance()->errorJson('省份不能为空');
        }
        if (empty($city)) {
            return ResponseJson::getInstance()->errorJson('城市不能为空');
        }
        if (empty($detail)) {
            return ResponseJson::getInstance()->errorJson('详细地址不能为空');
        }

        if($addressId){
            $addressInfo = MemberAddress::where('id', $addressId)->where('member_id', $memberId)->first();
            if(empty($addressInfo)) return ResponseJson::getInstance()->errorJson('收货地址不存在');
            $addressInfo->update([
                'name' => $name,
                'phone_number' => $phoneNumber,
                'province' => $province,
                'city' => $city,
                'area' => $area,
                'detail_address' => $detail,
            ]);
        }else{
            $address = MemberAddress::create([
                'member_id' => $memberId,
                'name' => $name,
                'phone_number' => $phoneNumber,
                'province' => $province,
                'city' => $city,
                'area' => $area,
                'detail_address' => $detail,
                'is_default' => 0,
            ]);
        }
        return ResponseJson::getInstance()->doneJson('成功');
    }

    public function getArea(){
        $list = \Cache::remember('areaList', 1440, function () {
            $province = \DB::table('province')->select(['id', 'name'])->get()->toArray();
            $city = \DB::table('city')->select(['id', 'pid', 'name'])->get()->toArray();
            $area = \DB::table('area')->select(['id', 'pid', 'name'])->get()->toArray();

            $list = [];
            $list2 = [];
            $list3 = [];
            foreach ($city as $v){
                $list[$v->pid][] = $v;
            }
            foreach ($area as $v){
                $list2[$v->pid][] = $v;
            }
            foreach ($province as $k => $v){
                $list3[$k] = array($v);
                // 遍历市区信息
                foreach ($list[$v->id] as $key=>$val){
                    $list[$v->id][$key]->area = $list2[$val->id];
                }
                $list3[$k]['city'] = $list[$v->id];
            }
            return $list3;
        });

        return ResponseJson::getInstance()->doneJson('',$list);
    }

    /**
     * 获取收货地址列表
     *
     * @param Request $request
     * @return array
     */
    public function getAddressList(Request $request) {
        $memberId = $request->user()->id;
        $addressList = MemberAddress::whereMemberId($memberId)->get()->toArray();
        $addresses = [];
        foreach ($addressList as $key => $value) {
            $addresses[$value['id']] = $value;
        }
        return ResponseJson::getInstance()->doneJson('获取成功', $addresses);
    }

    /**
     * 删除收货地址
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAddress(Request $request) {
        $memberId = $request->user()->id;
        $addressId = intval($request->input('id'));

        MemberAddress::whereMemberId($memberId)->whereId($addressId)->delete();
        return ResponseJson::getInstance()->doneJson('删除成功');
    }

    /**
     * 设置默认收货地址
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setDefaultAddress(Request $request) {
        $memberId = $request->user()->id;
        $addressId = intval($request->input('id'));

        \DB::beginTransaction();
        try {
            $address = MemberAddress::whereMemberId($memberId)->whereId($addressId)->first();
            if ($address) {
                MemberAddress::whereMemberId($memberId)->update(['is_default' => 0]);
                MemberAddress::whereMemberId($memberId)->whereId($addressId)->update(['is_default' => 1]);
            }
            \DB::commit();
            return ResponseJson::getInstance()->doneJson('设置默认成功');
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new ApiException($e);
        }
    }

    /**
     * 动态计算邮费
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrderFreight(Request $request) {
        $memberId = $request->user()->id;
        $addressId = intval($request->input('address_id'));
        $cartIds = trim($request->input('cart_ids'));
        $totalGoodsWeight = 0;
        $freightPrice = 0 ;

        if (empty($cartIds)) {
            return ResponseJson::getInstance()->errorJson('请选择要结算的商品');
        }
        $cartIds = array_filter(explode(',', $cartIds));
        $cartIds = array_map('intval', $cartIds);
        if (Cart::whereMemberId($memberId)->whereIn('id', $cartIds)->count() == 0) {
            return ResponseJson::getInstance()->errorJson('结算商品不存在');
        }
        $address = MemberAddress::whereMemberId($memberId)->whereId($addressId)->first();
        $cartGoods = Cart::whereMemberId($memberId)->whereIn('id', $cartIds)->get();
        foreach ($cartGoods as $key => $value) {
            // 只计算不包邮的商品
            if ($value->goods->is_free_shipping == 0) {
                $totalGoodsWeight += $value->goods->goods_weight * $value->goods_number;
            }
        }
        if ($address) {
            $freightPrice = Order::getInstance()->getCartGoodsFreightPrice($totalGoodsWeight, $address->province);
        } else {
            $freightPrice = Order::getInstance()->getCartGoodsFreightPrice($totalGoodsWeight, '北京市');
        }
        $freightPrice = CommonHelper::getInstance()->formatPriceToShow($freightPrice);
        return ResponseJson::getInstance()->doneJson('邮费计算成功', $freightPrice);
    }

    /**
     * 订单列表
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrderList(Request $request) {
        $memberId = $request->user()->id;
        $page = $request->input('page',1);
        $pagesize = $request->input('pagesize',10);
        $status = intval($request->input('status'));
        $query = Order::whereMemberId($memberId)->where('status','<>',0)->orderBy('id','desc');

        if ($status > 0) { $query->whereStatus($status); }
        $orders = $query->offset(($page - 1)*$pagesize)->limit($pagesize)->get();
        $orderList = [];
        foreach ($orders as $key => $value) {
            $orderList[$key]['order_id'] = $value->id;
            $orderList[$key]['order_sn'] = $value->order_sn;
            $orderList[$key]['create_time'] = date('Y/m/d', $value->create_time);
            $orderList[$key]['status'] = $value->status;
            $orderList[$key]['status_text'] = $value->status_text;
            $orderList[$key]['goods_number'] = $value->goods_number;
            $orderList[$key]['is_rebate'] = $value->is_rebate;
            $orderList[$key]['order_price'] = ceil(($value->order_price + $value->freight_price)/100);

            // 获取第一个订单商品
            $orderList[$key]['first_goods'] = [];
            $goods = OrderGoods::whereOrderId($value->id)->first();
            $orderList[$key]['first_goods']['goods_name'] = $goods->goods_name;
            $orderList[$key]['first_goods']['goods_number'] = $goods->goods_number;
            $orderList[$key]['first_goods']['goods_price'] =  CommonHelper::getInstance()->formatPriceToShow($goods->goods_price);
            $orderList[$key]['first_goods']['thumb'] = Goods::getInstance()->getGoodsSkuThumb($goods->sku_id);
            $orderList[$key]['first_goods']['sku_str'] = $goods->sku_str;

        }
        return ResponseJson::getInstance()->doneJson('订单查询成功', $orderList);
    }

    /**
     * 关闭订单(待付款状态)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function closeOrder(Request $request) {
        $memberId = $request->user()->id;
        $orderId = intval($request->input('order_id'));
        \DB::beginTransaction();
        try {
            $is_success = Order::getInstance()->cancelOrder($memberId, $orderId);
            if ($is_success !== true) {
                \DB::rollBack();
                return $is_success;
            }
            \DB::commit();
            return ResponseJson::getInstance()->doneJson('订单关闭成功');
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new ApiException($e);
        }
    }

    /**
     * 取消订单(已付款状态)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelOrder(Request $request) {
        $memberId = $request->user()->id;
        $orderId = intval($request->input('order_id'));
        \DB::beginTransaction();
        try {
            $is_success = Order::getInstance()->cancelOrder($memberId, $orderId);
            if ($is_success !== true) {
                \DB::rollBack();
                return $is_success;
            }
            \DB::commit();
            return ResponseJson::getInstance()->doneJson('订单取消成功');
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new ApiException($e);
        }
    }

    /**
     * 提醒订单发货
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function rememberOrder(Request $request) {
        $memberId = $request->user()->id;
        $orderId = intval($request->input('order_id'));
        \DB::beginTransaction();
        try {
            Order::getInstance()->rememberOrder($memberId, $orderId);
            \DB::commit();
            return ResponseJson::getInstance()->doneJson('提醒发货成功');
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new ApiException($e);
        }
    }

    /**
     * 确认收货
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function finishOrder(Request $request) {
        $memberId = $request->user()->id;
        $orderId = intval($request->input('order_id'));
        \DB::beginTransaction();
        try {
            $is_success = Order::getInstance()->finishOrder($memberId, $orderId, true);
            if($is_success !== true){
                \DB::rollBack();
                return $is_success;
            }
            \DB::commit();
            return ResponseJson::getInstance()->doneJson('订单确认收货成功');
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new ApiException($e);
        }
    }

    /**
     * 查看物流
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function orderLogistics(Request $request) {
        $memberId = $request->user()->id;
        $orderId = intval($request->input('order_id'));

        $order = Order::whereMemberId($memberId)->whereId($orderId)->first();
        if (!$order) {
            return ResponseJson::getInstance()->errorJson('订单不存在');
        }
        $express = Express::whereId($order->express_id)->first();

        $expressInfo = ExpressLibrary::getInstance()->getExpressInfo($express->express_code, $order->tracking_number);
        $expressInfo = json_decode($expressInfo, true);
        $expressInfo['name'] = $express->express_name;
        $expressInfo['Traces'] = array_reverse($expressInfo['Traces']);
        return ResponseJson::getInstance()->doneJson('获取成功', $expressInfo);
    }

    /**
     * 订单详情
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function orderDetail(Request $request) {
        $memberId = $request->user()->id;
        $orderId = intval($request->input('order_id'));

        $order = Order::whereMemberId($memberId)
            ->whereId($orderId)
            ->select([
                'id',
                'member_id',
                'order_sn',
                'order_price',
                'freight_price',
                'created_at',
                'is_pay',
                'pay_price',
                'pay_time',
                'status',
                'receiver_name',
                'receiver_phone_number',
                'receiver_detail',
            ])
            ->first();
        if (!$order) {
            return ResponseJson::getInstance()->errorJson('订单不存在');
        }
        //订单商品
        $orderGoods = OrderGoods::whereOrderId($order->id)
            ->select([
                'goods_id',
                'goods_price',
                'goods_number',
                'sku_id',
                'sku_str',
            ])
            ->get()->toArray();
        foreach ($orderGoods as $key => $value) {
            $orderGoods[$key]['goods_price'] = CommonHelper::getInstance()->formatPriceToShow($value['goods_price']);
            $orderGoods[$key]['thumb'] = Goods::getInstance()->getGoodsSkuThumb($value['sku_id']);
        }
        if ($order->express_id) {
            $express = Express::whereId($order->express_id)->first();
            $expressInfo = ExpressLibrary::getInstance()->getExpressInfo($express->express_code, $order->tracking_number);
            $expressInfo = json_decode($expressInfo, true);
            $order['express_name'] = $express->express_name;
            $expressInfo['Traces'] = array_reverse($expressInfo['Traces']);
            $order['new_trace'] = isset($expressInfo['Traces'][0]) ? '<a href="'.url('member/orderLogistics').'?order_id='.$order['id'].'">'.$expressInfo['Traces'][0]['AcceptStation'].'</a>' : $order['new_trace'];
            $order['LogisticCode'] = isset($expressInfo['LogisticCode']) ? $expressInfo['LogisticCode'] : $order['LogisticCode'];
        }
        // 格式化订单信息
        $order['order_price'] = CommonHelper::getInstance()->formatPriceToShow($order['order_price']);
        $order['freight_price'] = CommonHelper::getInstance()->formatPriceToShow($order['freight_price']);

        $order['orderGoods'] = $orderGoods;
        return ResponseJson::getInstance()->doneJson('', $order);
    }
}
