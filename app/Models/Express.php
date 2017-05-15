<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Express
 *
 * @property int $id
 * @property string $express_name 快递公司名称
 * @property string $express_code 快递公司编码
 * @property int $is_open 是否开启
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Express whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Express whereExpressName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Express whereExpressCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Express whereIsOpen($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Express whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Express whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Express extends Model
{
    use BaseModelTrait;

    protected $table = 'express';

    protected $guarded = ['id'];

    protected $appends = [];
}
