<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MobileCode
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $mobile 手机号码
 * @property int $code 验证码
 * @property string $type 验证码类型，详见model
 * @property bool $status 是否已使用
 * @property int $num 发送次数
 * @property int $time 发送时间
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MobileCode whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MobileCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MobileCode whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MobileCode whereMobile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MobileCode whereNum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MobileCode whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MobileCode whereTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MobileCode whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MobileCode whereUpdatedAt($value)
 */
class MobileCode extends Model
{
    protected $table = 'mobile_code';

    protected $guarded = ['id'];

    protected $appends = [];
}
