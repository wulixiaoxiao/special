<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CircleAttention
 *
 * @property int $id
 * @property int $member_id 用户id
 * @property int $circle_category_id 圈子分类id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleAttention whereCircleCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleAttention whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleAttention whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleAttention whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleAttention whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\CircleCategory $category
 */
class CircleAttention extends Model
{
    protected $table = 'circle_attention';
    protected $guarded = ['id'];

    public function category(){
        return $this->belongsTo(CircleCategory::class, 'circle_category_id', 'id');
    }
}
