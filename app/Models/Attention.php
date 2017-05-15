<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Attention
 *
 * @property int $id
 * @property int $member_id 用户id
 * @property int $attention_id 关注用户id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Attention whereAttentionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Attention whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Attention whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Attention whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Attention whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\User $user
 */
class Attention extends Model
{
    protected $table = 'attention';

    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class, 'member_id', 'id');
    }

}
