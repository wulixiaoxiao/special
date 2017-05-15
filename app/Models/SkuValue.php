<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SkuValue
 *
 * @property int $id
 * @property int $sku_id SKU id
 * @property string $sku_value_name SKU可选项名称
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Sku $sku
 * @property-read mixed $sku_name
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SkuValue whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SkuValue whereSkuId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SkuValue whereSkuValueName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SkuValue whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SkuValue whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SkuValue extends Model
{
    use BaseModelTrait;

    protected $table = 'sku_value';

    protected $guarded = ['id'];

    protected $appends = ['sku_name'];

    public function sku() {
        return $this->belongsTo(Sku::class, 'sku_id', 'id');
    }

    public function getSkuNameAttribute() {
        return $this->sku()->value('sku_name');
    }
}
