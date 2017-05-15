<?php

namespace App\Models;

use App\Helper\CommonHelper;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Recommend
 *
 * @property int $id
 * @property int $circle_id 圈子内容id
 * @property string $title 标题
 * @property string $categroy_name 分类名称
 * @property int $length 视频时长,单位秒
 * @property int $sort 排序
 * @property string $cover_img 封面图
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Recommend whereCategroyName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Recommend whereCircleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Recommend whereCoverImg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Recommend whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Recommend whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Recommend whereLength($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Recommend whereSort($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Recommend whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Recommend whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property bool $is_show 是否显示
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Recommend whereIsShow($value)
 * @property string $video_url 视频地址
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Recommend whereVideoUrl($value)
 */
class Recommend extends Model
{
    protected $table = 'recommend';
    protected $guarded = ['id'];

    public function getCoverImgAttribute($value) {
        return CommonHelper::getInstance()->getOssPath($value);
    }

    public function getVideoUrlAttribute($value) {
        return CommonHelper::getInstance()->getOssPath($value);
    }


}
