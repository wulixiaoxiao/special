<?php

namespace App\Models;

use App\Exceptions\ApiException;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GoodsSku
 *
 * @property int $id
 * @property int $goods_id 商品ID
 * @property string $sku_ids 规格ID值组合
 * @property string $sku_values 规格属性值组合
 * @property int $market_price 市场价格,以分为单位
 * @property int $selling_price 实际价格,以分为单位
 * @property int $stock 库存数
 * @property bool $is_default 是否默认规格(1:是,0否)
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Goods[] $goodsImages
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSku whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSku whereGoodsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSku whereSkuIds($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSku whereSkuValues($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSku whereMarketPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSku whereSellingPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSku whereStock($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSku whereIsDefault($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSku whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSku whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $sku_value_ids 规格属性值组合
 * @property-read \App\Models\Goods $goods
 * @property-read mixed $goods_name
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSku whereSkuValueIds($value)
 * @property-read mixed $sku_ids_string
 * @property-read mixed $sku_value_ids_string
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cart[] $cart
 */
class GoodsSku extends Model
{
    use BaseModelTrait;

    protected $table = 'goods_sku';

    protected $guarded = ['id'];

    protected $appends = ['goods_name', 'sku_ids_string', 'sku_value_ids_string'];

    public function goodsImages() {
        return $this->hasMany(Goods::class, 'goods_sku_id', 'id');
    }

    public function goods() {
        return $this->belongsTo(Goods::class, 'goods_id', 'id');
    }

    public function cart() {
        return $this->hasMany(Cart::class, 'sku_id', 'id');
    }

    public function getGoodsNameAttribute() {
        return $this->goods()->value('goods_name');
    }

    public function getSkuIdsStringAttribute() {
        if (!$this->sku_ids) {
            return '';
        }
        $skuIds = array_filter(explode(',', $this->sku_ids));
        $skuIdsString = Sku::whereIn('id', $skuIds)->pluck('sku_name')->toArray();
        return implode(',', $skuIdsString);

    }

    public function getSkuValueIdsStringAttribute() {
        if (!$this->sku_value_ids) {
            return '';
        }
        $skuValueIds = array_filter(explode(',', $this->sku_value_ids));
        $skuValueIdsString = SkuValue::whereIn('id', $skuValueIds)->pluck('sku_value_name')->toArray();
        return implode(',', $skuValueIdsString);

    }
}
