<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderGoods
 *
 * @property int $id
 * @property int $order_id 订单ID
 * @property int $goods_id 商品ID
 * @property int $goods_price 商品单价(单位:分)
 * @property int $goods_number 商品数量
 * @property int $goods_weight 商品重量(单位:克)
 * @property int $sku_id 规格ID
 * @property string $sku_str 规格属性值组合
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGoods whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGoods whereOrderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGoods whereGoodsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGoods whereGoodsPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGoods whereGoodsNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGoods whereGoodsWeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGoods whereSkuId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGoods whereSkuStr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGoods whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGoods whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\OrderRebate $orderRebate
 * @property-read mixed $goods_name
 * @property-read \App\Models\Goods $goods
 * @property-read \App\Models\Order $order
 * @property bool $is_free_shipping 是否免邮
 * @property int $goods_margin 商品毛利
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGoods whereGoodsMargin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGoods whereIsFreeShipping($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FansRebate[] $fansRebate
 * @property-read \App\Models\GoodsComment $goodsComment
 * @property int $back_goods_number 退货数量
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGoods whereBackGoodsNumber($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AfterSale[] $afterSale
 */
class OrderGoods extends Model
{
    use BaseModelTrait;

    protected $table = 'order_goods';

    protected $guarded = ['id'];

    protected $appends = ['goods_name'];

//    public function orderRebate() {
//        return $this->hasOne(OrderRebate::class, 'order_goods_id', 'id');
//    }

    public function order() {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function goods() {
        return $this->belongsTo(Goods::class, 'goods_id', 'id');
    }

//    public function fansRebate() {
//        return $this->hasMany(FansRebate::class, 'order_goods_id', 'id');
//    }

    public function goodsComment() {
        return $this->hasOne(GoodsComment::class, 'order_goods_id', 'id');
    }

    public function afterSale() {
        return $this->hasMany(AfterSale::class, 'order_goods_id', 'id');
    }

    public function getGoodsNameAttribute() {
        return $this->goods()->value('goods_name');
    }
}
