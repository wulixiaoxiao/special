<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SpecialLikes
 *
 * @property int $id
 * @property int $member_id 点赞人id
 * @property int $circle_id 专题id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SpecialLikes whereCircleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SpecialLikes whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SpecialLikes whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SpecialLikes whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SpecialLikes whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $special_id 专题id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SpecialLikes whereSpecialId($value)
 * @property-read \App\Models\Special $special
 */
class SpecialLikes extends Model
{
    protected $table = 'special_likes';

    protected $guarded = ['id'];

    public function special(){
        return $this->belongsTo(Special::class, 'special_id', 'id');
    }

}
