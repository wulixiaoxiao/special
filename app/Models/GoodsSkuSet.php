<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GoodsSkuSet
 *
 * @property int $id
 * @property int $goods_id 商品ID
 * @property int $sku_id SKU id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Goods $goods
 * @property-read mixed $sku_name
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSkuSet whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSkuSet whereGoodsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSkuSet whereSkuId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSkuSet whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSkuSet whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Sku $sku
 */
class GoodsSkuSet extends Model
{
    use BaseModelTrait;

    protected $table = 'goods_sku_set';

    protected $guarded = ['id'];

    protected $appends = ['goods_name'];

    public function goods() {
        return $this->belongsTo(Goods::class, 'goods_id', 'id');
    }

    public function sku() {
        return $this->hasOne(Sku::class, 'sku_id', 'id');
    }

    public function getSkuNameAttribute() {
        return $this->goods()->value('goods_name');
    }
}
