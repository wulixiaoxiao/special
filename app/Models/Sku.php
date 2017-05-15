<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Sku
 *
 * @property int $id
 * @property string $sku_name 规格名称
 * @property string $sku_values 规格值组(英文逗号分隔)
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Goods[] $goodsImages
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sku whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sku whereSkuName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sku whereSkuValues($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sku whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sku whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SkuValue[] $skuValue
 * @property-read \App\Models\GoodsSkuSet $goodsSkuSet
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Goods[] $goods
 * @property-read mixed $sku_value_names
 */
class Sku extends Model
{
    use BaseModelTrait;

    protected $table = 'sku';

    protected $guarded = ['id'];

    protected $appends = ['sku_value_names'];

    public function skuValue() {
        return $this->hasMany(SkuValue::class, 'sku_id', 'id');
    }

    public function goodsSkuSet() {
        return $this->belongsTo(GoodsSkuSet::class, 'sku_id', 'id');
    }

    public function goods() {
        return $this->belongsToMany(Goods::class, 'goods_sku_set', 'sku_id', 'goods_id');
    }

    public function getSkuValueNamesAttribute() {
        $names = SkuValue::whereSkuId($this->id)->pluck('sku_value_name')->toArray();
        if (!empty($names)) {
            return implode(',', $names);
        } else {
            return '';
        }
    }
}
