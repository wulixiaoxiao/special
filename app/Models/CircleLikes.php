<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\CircleLikes
 *
 * @property int $id
 * @property int $member_id 点赞人id
 * @property int $circle_id 动态id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleLikes whereCircleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleLikes whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleLikes whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleLikes whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleLikes whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Circle $circle
 * @property-read \App\Models\User $user
 */
class CircleLikes extends Model
{
    use BaseModelTrait;

    protected $table = 'circle_likes';

    protected $guarded = ['id'];

    public function circle(){
        return $this->belongsTo(Circle::class);
    }

    public function user(){
        return $this->belongsTo(User::class,'member_id','id');

    }

}
