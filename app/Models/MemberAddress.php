<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MemberAddress
 *
 * @property int $id
 * @property int $member_id 会员ID
 * @property string $name 姓名
 * @property string $phone_number 手机号码
 * @property int $province 省份
 * @property int $city 城市
 * @property int $area 区域
 * @property string $detail_address 详细地址
 * @property bool $is_default 是否是默认(1:是,0:否,默认否)
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Member $member
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberAddress whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberAddress whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberAddress whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberAddress wherePhoneNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberAddress whereProvince($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberAddress whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberAddress whereArea($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberAddress whereDetailAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberAddress whereIsDefault($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberAddress whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MemberAddress extends Model
{
    use BaseModelTrait;
    protected $table = 'member_address';

    protected $guarded = ['id'];

    protected $appends = [];

    public function member() {
        return $this->belongsTo(User::class, 'member_id', 'id');
    }
}
