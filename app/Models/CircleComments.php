<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



/**
 * App\Models\CircleComments
 *
 * @property int $id
 * @property int $member_id 评论人id
 * @property int $reply_id 回复id
 * @property int $circle_id 动态id
 * @property string $comment 评论内容
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleComments whereCircleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleComments whereComment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleComments whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleComments whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleComments whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleComments whereReplyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleComments whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Circle $circle
 * @property-read \App\Models\User $user
 */
class CircleComments extends Model
{
    use BaseModelTrait;

    protected $table = 'circle_comments';

    protected $guarded = ['id'];

    public function circle(){
        return $this->belongsTo(Circle::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'member_id', 'id');
    }

}
