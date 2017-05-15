<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Cart
 *
 * @property int $id
 * @property int $member_id 会员ID
 * @property int $goods_id 商品ID
 * @property int $goods_number 购买商品数量
 * @property int $sku_id 规格ID
 * @property int $create_time 添加时间
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Member $member
 * @property-read \App\Models\Goods $goods
 * @property-read \App\Models\GoodsSku $goodsSku
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereGoodsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereGoodsNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereSkuId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereCreateTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Cart extends Model
{
    use BaseModelTrait;

    protected $table = 'cart';

    protected $guarded = ['id'];

    protected $appends = [];

    public function member() {
        return $this->belongsTo(User::class, 'member_id', 'id');
    }

    public function goods() {
        return $this->belongsTo(Goods::class, 'goods_id', 'id');
    }

    public function goodsSku() {
        return $this->belongsTo(GoodsSku::class, 'sku_id', 'id');
    }
}
