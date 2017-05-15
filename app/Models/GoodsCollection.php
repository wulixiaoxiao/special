<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GoodsCollection
 *
 * @property int $id
 * @property int $member_id 会员ID
 * @property int $goods_id 商品ID
 * @property int $create_time 添加时间
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Member $member
 * @property-read \App\Models\Goods $goods
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsCollection whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsCollection whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsCollection whereGoodsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsCollection whereCreateTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsCollection whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsCollection whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GoodsCollection extends Model
{
    use BaseModelTrait;

    protected $table = 'goods_collection';

    protected $guarded = ['id'];

    protected $appends = [];

    public function member() {
        return $this->belongsTo(User::class, 'member_id', 'id');
    }

    public function goods() {
        return $this->belongsTo(Goods::class, 'goods_id', 'id');
    }
}
