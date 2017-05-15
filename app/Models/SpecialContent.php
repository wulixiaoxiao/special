<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SpecialContent
 *
 * @property int $id
 * @property int $special_id 专题id
 * @property bool $sort 内容排序
 * @property bool $type 类型，1图片2视频
 * @property string $content 文字内容
 * @property string $filePath 图片视频地址
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SpecialContent whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SpecialContent whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SpecialContent whereFilePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SpecialContent whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SpecialContent whereSort($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SpecialContent whereSpecialId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SpecialContent whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SpecialContent whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Special $special
 */
class SpecialContent extends Model
{
    protected $table = 'special_content';
    protected $guarded = ['id'];

    public function special(){
        return $this->belongsTo(Special::class, 'special_id', 'id');
    }
}
