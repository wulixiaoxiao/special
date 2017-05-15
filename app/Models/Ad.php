<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helper\CommonHelper;

/**
 * App\Models\Ad
 *
 * @property int $id
 * @property int $ad_position_id 广告位置ID
 * @property string $ad_name 广告名称
 * @property string $title 标题
 * @property string $pic 广告图片路径
 * @property string $link 广告链接
 * @property int $sort_order 排序
 * @property bool $is_show 是否显示
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ad whereAdName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ad whereAdPositionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ad whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ad whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ad whereIsShow($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ad whereLink($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ad wherePic($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ad whereSortOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ad whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ad whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\AdPosition $adPosition
 * @property-read mixed $pic_path
 * @property-read mixed $position_name
 */
class Ad extends Model
{
    use BaseModelTrait;

    protected $table = 'ad';
    protected $guarded = ['id'];
    protected $appends = ['position_name', 'pic_path'];

    public function adPosition() {
        return $this->belongsTo(AdPosition::class, 'ad_position_id', 'id');
    }

    public function getPositionNameAttribute() {
        return AdPosition::whereId($this->ad_position_id)->value('position_name');
    }

    public function getPicPathAttribute() {
        return CommonHelper::getInstance()->formatImageToShow($this->pic);
    }
}
