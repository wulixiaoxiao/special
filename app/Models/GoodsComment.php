<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GoodsComment
 *
 * @property int $id
 * @property int $member_id 会员ID
 * @property int $order_id 订单ID
 * @property int $goods_id 商品ID
 * @property string $content 评论内容
 * @property bool $is_show 是否显示(1:显示,0:隐藏,默认显示)
 * @property int $create_time 添加时间
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Goods $goods
 * @property-read \App\Models\Order $order
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsComment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsComment whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsComment whereOrderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsComment whereGoodsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsComment whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsComment whereIsShow($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsComment whereCreateTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsComment whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Member $member
 * @property int $order_goods_id 订单商品ID
 * @property-read mixed $goods_name
 * @property-read mixed $member_name
 * @property-read mixed $order_sn
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsComment whereOrderGoodsId($value)
 * @property-read \App\Models\OrderGoods $orderGoods
 */
class GoodsComment extends Model
{
    use BaseModelTrait;

    protected $table = 'goods_comment';

    protected $guarded = ['id'];

    protected $appends = ['member_name', 'goods_name', 'order_sn'];

    public function goods() {
        return $this->belongsTo(Goods::class, 'goods_id', 'id');
    }

    public function order() {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function member() {
        return $this->belongsTo(User::class, 'member_id', 'id');
    }

    public function orderGoods() {
        return $this->belongsTo(OrderGoods::class, 'order_goods_id', 'id');
    }

    public function getMemberNameAttribute() {
        return $this->member()->value('name');
    }

    public function getGoodsNameAttribute() {
        return $this->goods()->value('goods_name');
    }

    public function getOrderSnAttribute() {
        return $this->order()->value('order_sn');
    }
}
