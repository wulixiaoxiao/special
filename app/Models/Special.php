<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Special
 *
 * @property int $id
 * @property string $title 专题标题
 * @property int $category_id 分类id
 * @property int $type 类型，1文章2视频
 * @property string $url 视频地址
 * @property string $content 内容
 * @property int $likes 点赞数
 * @property int $comments 评论数
 * @property int $is_recommend 是否推荐
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Special whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Special whereComments($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Special whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Special whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Special whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Special whereIsRecommend($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Special whereLikes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Special whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Special whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Special whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Special whereUrl($value)
 * @mixin \Eloquent
 * @property int $sort_order 排序
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Special whereSortOrder($value)
 * @property string $subtitle 专题副标题
 * @property string $description 专题描述
 * @property-read \App\Models\SpecialCategory $category
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Special whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Special whereSubtitle($value)
 * @property string $goodids 关联商品id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Special whereGoodids($value)
 */
class Special extends Model
{
    use BaseModelTrait;

    protected $table = 'special';

    protected $guarded = ['id'];

    public function category(){
        return $this->belongsTo(SpecialCategory::class, 'category_id', 'id');
    }

    public function content(){
        return $this->hasMany(SpecialContent::class, 'special_id', 'id');
    }

    public function likes(){
        return $this->hasMany(SpecialLikes::class, 'special_id', 'id');
    }

    public function comments(){
        return $this->hasMany(SpecialComments::class, 'special_id', 'id');
    }

}
