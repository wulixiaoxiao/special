<?php

namespace App\Models;

use App\Helper\CommonHelper;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Circle
 *
 * @property int $id
 * @property int $member_id 作者id
 * @property string $author 作者昵称
 * @property bool $type 动态类型,1文字,2文字加图片,3文字加视频
 * @property string $title 标题
 * @property string $content 内容，图片链接或视频链接
 * @property int $likes 点赞数
 * @property int $comments 评论数
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Circle whereAuthor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Circle whereComments($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Circle whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Circle whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Circle whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Circle whereLikes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Circle whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Circle whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Circle whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Circle whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CircleComments[] $circleComments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CircleLikes[] $circleLikes
 * @property-read \App\Models\User $user
 * @property string $tag 标签
 * @property int $category_id 分类名称
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Circle whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Circle whereTag($value)
 * @property string $links 图片链接或视频链接
 * @property string $coordinate 位置
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Circle whereCoordinate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Circle whereLinks($value)
 * @property int $length 视频时长，单位秒
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Circle whereLength($value)
 */
class Circle extends Model
{
    use BaseModelTrait;

    protected $table = 'circle';

    protected $guarded = ['id'];

    public function circleLikes(){
        return $this->hasMany(CircleLikes::class);
    }

    public function circleComments(){
        return $this->hasMany(CircleComments::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'member_id', 'id');
    }

    public function category(){
        return $this->belongsTo(CircleCategory::class, 'category_id', 'id');
    }

    public function getLinksAttribute($value) {
        $value = explode(',', $value);
        foreach ($value as &$v){
            $v = CommonHelper::getInstance()->getOssPath($v);
        }
        return implode(',', $value);
    }

}
