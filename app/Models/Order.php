<?php

namespace App\Models;

use App\Exceptions\ApiException;
use App\Helper\ResponseJson;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $member_id 会员ID
 * @property string $order_sn 订单编号
 * @property int $order_price 订单总金额,以分为单位
 * @property int $goods_price 商品总金额,以分为单位
 * @property int $freight_price 运费金额,以分为单位
 * @property int $goods_number 订单产品总数量
 * @property int $goods_weight 订单产品总重量
 * @property int $pay_price 订单支付金额,以分为单位
 * @property bool $pay_type 支付类型(1:余额,2:微信,3:支付宝)
 * @property string $pay_number 支付流水号
 * @property int $pay_time 支付时间
 * @property bool $is_pay 是否支付(1:是,0:否)
 * @property string $order_note 订单备注
 * @property int $status 订单状态(0:交易取消,1:未付款,2:已付款,3:已发货,4:退货中,5:交易完成,6:交易关闭,7:退货完成,8:满7天,9:未审核,10:订单关闭)
 * @property int $member_address_id 收货地址ID
 * @property int $express_id 快递公司ID
 * @property string $tracking_number 快递单号
 * @property bool $is_rebate 是否返利(1:是,0:否)
 * @property int $create_time 订单生成时间
 * @property int $deliver_time 订单发货时间
 * @property int $receiving_time 订单收货时间
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GoodsComment[] $goodsComment
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereOrderSn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereOrderPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereGoodsPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereFreightPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereGoodsNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereGoodsWeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order wherePayPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order wherePayType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order wherePayNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order wherePayTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereIsPay($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereOrderNote($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereMemberAddressId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereExpressId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereTrackingNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereIsRebate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereCreateTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereDeliverTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereReceivingTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Member $member
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderLog[] $orderLog
 * @property string $receiver_name 收货人姓名
 * @property string $receiver_phone_number 收货人手机号码
 * @property string $receiver_province 收货人身份
 * @property string $receiver_city 收货人城市
 * @property string $receiver_area 收货人区域
 * @property string $receiver_detail 收货人详细地址
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderGoods[] $orderGoods
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereReceiverArea($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereReceiverCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereReceiverDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereReceiverName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereReceiverPhoneNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereReceiverProvince($value)
 * @property-read mixed $status_text
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FansRebate[] $fansRebate
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderRebate[] $orderRebate
 * @property bool $is_back_goods 是否退货中(1:是,0:否)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereIsBackGoods($value)
 */
class Order extends Model
{
    use BaseModelTrait;

    protected $table = 'order';

    protected $guarded = ['id'];

    protected $appends = ['status_text'];

    public function goodsComment() {
        return $this->hasMany(GoodsComment::class, 'order_id', 'id');
    }

    public function member() {
        return $this->belongsTo(User::class, 'member_id', 'id');
    }

    public function orderLog() {
        return $this->hasMany(OrderLog::class, 'order_id', 'id');
    }

    public function orderGoods() {
        return $this->hasMany(OrderGoods::class, 'order_id', 'id');
    }

//    public function orderRebate() {
//        return $this->hasMany(OrderRebate::class, 'order_id', 'id');
//    }

//    public function fansRebate() {
//        return $this->hasMany(FansRebate::class, 'order_id', 'id');
//    }

//    public function coinRebate() {
//        return $this->hasMany(CoinRebate::class, 'order_id', 'id');
//    }

    public function getStatusTextAttribute() {
        if ($this->status == 0) {
            return '已取消';
        } elseif ($this->status == 1) {
            return '待付款';
        } elseif ($this->status == 2) {
            return '待发货';
        }  elseif ($this->status == 3) {
            return '待确认';
        }  elseif ($this->status == 4) {
            return '已完成';
        }
    }

    /**
     * 获取购物车商品信息
     *
     * @param $cartGoods
     * @param $memberId
     * @param int $addressId
     * @return array
     */
    public function getCartGoodsInfo($cartGoods, $memberId, $addressId = 0) {
        $totalGoodsWeight = 0;
        $totalGoodsPrice = 0;
        $freightPrice = 0;
//        $totalGoodsRebate = 0;
        $totalGoodsNumber = 0;

        $defaultAddress = MemberAddress::whereMemberId($memberId)->whereIsDefault(1)->first();
        if ($addressId > 0) {
            $address = MemberAddress::whereMemberId($memberId)->whereId($addressId)->first();
        } else {
            $address = $defaultAddress;
        }
        foreach ($cartGoods as $key => $value) {
            $totalGoodsNumber += $value->goods_number;
//            $totalGoodsRebate += Goods::getInstance()->getGoodsRebate($value->goods->goods_margin) * $value->goods_number;
            $totalGoodsPrice += $value->goodsSku->selling_price * $value->goods_number;
            // 只计算不包邮的商品
            if ($value->goods->is_free_shipping == 0) {
                $totalGoodsWeight += $value->goods->goods_weight * $value->goods_number;
            }
        }
        if ($address) {
            $freightPrice = $this->getCartGoodsFreightPrice($totalGoodsWeight, $address->city);
        } else {
            $freightPrice = $this->getCartGoodsFreightPrice($totalGoodsWeight, '北京市');
        }

        return [
            'totalGoodsWeight' => $totalGoodsWeight,
            'totalGoodsPrice' => $totalGoodsPrice,
//            'totalGoodsRebate' => $totalGoodsRebate,
            'freightPrice' => $freightPrice,
            'defaultAddress' => $defaultAddress,
            'totalOrderPrice' => $totalGoodsPrice + $freightPrice,
            'totalGoodsNumber' => $totalGoodsNumber,
        ];
    }

    /**
     * 计算订单运费
     *
     * @param $weight
     * @param $city
     * @return int
     */
    public function getCartGoodsFreightPrice($weight, $city) {
        if ($weight <= 0) {
            return 0;
        }
        $freight = Deliver::leftJoin('deliver_price', 'deliver.id', '=', 'deliver_price.deliver_id')
            ->leftJoin('express', 'express.id', '=', 'deliver.logistics_id')
            ->where('express.express_code', '=', 'QFKD')
            ->where('deliver_price.city', 'like', '%'.$city.'%')
            ->first();
        // 默认运费是10元
        if (!$freight) {
            return 1000;
        }
        $overWeight = $weight - $freight->first_weight;
        if ($overWeight <= 0) {
            return $freight->first_price;
        } else {
            return $freight->first_price + ceil($overWeight / $freight->add_weight) * $freight->add_price;
        }
    }

    /**
     * 生成订单号
     *
     * @return string
     */
    public function getOrderSn()
    {
        // strlen 19
        do{
            $orderSn = (string) date('ymd').substr(time(), 2).mt_rand(10000,99999);
        }while(Order::whereOrderSn($orderSn)->value('id'));
        return $orderSn;
    }

    /**
     * 取消订单
     *
     * @param $member_id
     * @param $order_id
     * @return bool
     */
    public function cancelOrder($member_id, $order_id) {
        $order = Order::whereId($order_id)->whereMemberId($member_id)->first();
        if (!$order) {
            return ResponseJson::getInstance()->errorJson('订单不存在');
        }

        if ($order->status != 1 && $order->status != 2) {
            return ResponseJson::getInstance()->errorJson('只有待付款和待发货的订单才可以进行此操作');
        }
        $order->status = 0;
        $order->save();

        if ($order->is_pay) {
            User::getInstance()->addMoney($order->member_id, $order->order_price, $order->id, Transactions::TYPE_CANCEL_ORDER, '取消订单');
            OrderLog::getInstance()->addLog($order->id, '订单取消:'.$order->order_sn);
        } else {
            OrderLog::getInstance()->addLog($order->id, '订单关闭:'.$order->order_sn);
        }
        return true;
    }

    /**
     * 提醒发货
     *
     * @param $member_id
     * @param $order_id
     * @return bool
     */
    public function rememberOrder($member_id, $order_id) {
        $order = Order::whereId($order_id)->whereMemberId($member_id)->first();
        if (!$order) {
            throw new ApiException('订单不存在');
        }
        if ($order->status != 2) {
            throw new ApiException('只有待发货的订单才可以进行此操作');
        }
        return true;
    }

    /**
     * 订单确认收货
     *
     * @param $member_id
     * @param $order_id
     * @return bool
     */
    public function finishOrder($member_id, $order_id) {
        $order = Order::whereId($order_id)->whereMemberId($member_id)->first();
        if (!$order) {
            return ResponseJson::getInstance()->errorJson('订单不存在');
        }
        if ($order->status != 3) {
            return ResponseJson::getInstance()->errorJson('只有待收货的订单才可以进行此操作');
        }
        $order->status = 4;
        $order->receiving_time = time();
        $order->save();

        OrderLog::getInstance()->addLog($order->id, '订单确认收货:'.$order->order_sn);
        return true;
    }
}
