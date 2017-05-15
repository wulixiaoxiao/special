<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SpecialCategory
 *
 * @property int $id
 * @property string $category_name 专题分类名称
 * @property int $sort_order 专题分类名称
 * @property bool $is_show 是否显示（1显示0不显示）
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SpecialCategory whereCategoryName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SpecialCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SpecialCategory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SpecialCategory whereIsShow($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SpecialCategory whereSortOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SpecialCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Special[] $special
 */
class SpecialCategory extends Model
{
    protected $table = 'special_category';
    protected $guarded = ['id'];

    public function special(){
        return $this->hasMany(Special::class, 'category_id', 'id');
    }

}
