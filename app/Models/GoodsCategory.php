<?php

namespace App\Models;

use App\Helper\CommonHelper;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GoodsCategory
 *
 * @property int $id
 * @property string $goods_category_name 商品分类名称
 * @property int $sort_order 排序
 * @property bool $is_show 是否显示
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsCategory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsCategory whereGoodsCategoryName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsCategory whereSortOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsCategory whereIsShow($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Goods[] $goods
 * @property string $category_img 商品分类图片
 * @property string $category_icon 分类图标
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsCategory whereCategoryIcon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsCategory whereCategoryImg($value)
 */
class GoodsCategory extends Model
{
    use BaseModelTrait;

    protected $table = 'goods_category';

    protected $guarded = ['id'];

    public function goods() {
        return $this->hasMany(Goods::class, 'goods_category_id', 'id');
    }

    public function getCategoryImgAttribute($value){
        return CommonHelper::getInstance()->getOssPath($value);
    }

    public function getCategoryIconAttribute($value){
        return CommonHelper::getInstance()->getOssPath($value);
    }

}
