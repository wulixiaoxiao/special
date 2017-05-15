<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SpecialComments
 *
 * @property int $id
 * @property int $member_id 评论人id
 * @property int $reply_id 回复id
 * @property int $circle_id 专题id
 * @property string $comment 评论内容
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SpecialComments whereCircleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SpecialComments whereComment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SpecialComments whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SpecialComments whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SpecialComments whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SpecialComments whereReplyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SpecialComments whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $special_id 专题id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SpecialComments whereSpecialId($value)
 * @property-read \App\Models\Special $special
 */
class SpecialComments extends Model
{
    protected $table = 'special_comments';

    protected $guarded = ['id'];

    public function special(){
        return $this->belongsTo(Special::class, 'special_id', 'id');
    }

}
