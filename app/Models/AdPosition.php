<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AdPosition
 *
 * @property int $id
 * @property string $position_name 广告位置名称
 * @property string $description 广告位置描述
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdPosition whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdPosition whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdPosition whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdPosition wherePositionName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdPosition whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ad[] $ad
 */
class AdPosition extends Model
{
    use BaseModelTrait;

    protected $table = 'ad_position';
    protected $guarded = ['id'];

    public function ad() {
        return $this->hasMany(Ad::class, 'ad_position_id', 'id');
    }
}
