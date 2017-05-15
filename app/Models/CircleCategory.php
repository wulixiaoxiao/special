<?php

namespace App\Models;

use App\Helper\CommonHelper;
use Illuminate\Database\Eloquent\Model;



/**
 * App\Models\CircleCategory
 *
 * @property int $id
 * @property string $category_name 圈子分类名称
 * @property int $sort_order 圈子分类名称
 * @property bool $is_show 是否显示（1显示0不显示）
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleCategory whereCategoryName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleCategory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleCategory whereIsShow($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleCategory whereSortOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $img_url 圈子分类图片
 * @property string $description 描述
 * @property int $people_num 圈子人数
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleCategory whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleCategory whereImgUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleCategory wherePeopleNum($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CircleAttention[] $attention
 */
class CircleCategory extends Model
{

    protected $table = 'circle_category';
    protected $guarded = ['id'];

    public function attention(){
        return $this->hasMany(CircleAttention::class, 'circle_category_id', 'id');
    }

    public function circle(){
        return $this->hasMany(Circle::class, 'category_id', 'id');
    }

    public function getImgUrlAttribute($value){
        return CommonHelper::getInstance()->getOssPath($value);
    }

}
