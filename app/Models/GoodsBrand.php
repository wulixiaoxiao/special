<?php

namespace App\Models;

use App\Helper\CommonHelper;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\GoodsBrand
 *
 * @property int $id
 * @property string $goods_brand_name 商品品牌名称
 * @property int $sort_order 排序
 * @property bool $is_show 是否显示
 * @property string $description 商品品牌介绍
 * @property string $logo 商品品牌LOGO
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsBrand whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsBrand whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsBrand whereGoodsBrandName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsBrand whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsBrand whereIsShow($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsBrand whereLogo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsBrand whereSortOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsBrand whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GoodsBrand extends Model
{
    protected $table = 'goods_brand';
    protected $guarded = ['id'];

    public function getLogoAttribute($value){
        return CommonHelper::getInstance()->getOssPath($value);
    }

}
