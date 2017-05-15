<?php

namespace App\Models;

use App\Helper\CommonHelper;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GoodsImages
 *
 * @property int $id
 * @property int $goods_sku_id 商品规格ID
 * @property bool $type 图片类型(1:缩略图,2:商品图片)
 * @property string $img_url 图片路径
 * @property int $sort_order 排序
 * @property int $create_time 添加时间
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Goods $sku
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsImages whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsImages whereGoodsSkuId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsImages whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsImages whereImgUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsImages whereSortOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsImages whereCreateTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsImages whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsImages whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Goods $goodsSku
 */
class GoodsImages extends Model
{
    use BaseModelTrait;

    protected $table = 'goods_images';

    protected $guarded = ['id'];

    public function goodsSku() {
        return $this->belongsTo(Goods::class, 'goods_sku_id', 'id');
    }

    public function getImgUrlAttribute($value){
        return CommonHelper::getInstance()->getOssPath($value);
    }

 }
