<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Transactions
 *
 * @property int $id
 * @property string $type 类型，确定target_id是哪个表的数据
 * @property int $target_id 目标id,根据type确定
 * @property int $member_id 会员ID
 * @property int $money 金额(以分为单位)
 * @property int $balance 用户余额(以分为单位)
 * @property string $description 描述
 * @property int $create_time 生成时间
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Transactions whereBalance($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Transactions whereCreateTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Transactions whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Transactions whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Transactions whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Transactions whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Transactions whereMoney($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Transactions whereTargetId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Transactions whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Transactions whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Transactions extends Model
{
    use BaseModelTrait;

    protected $table = 'transactions';

    protected $guarded = ['id'];

    protected $appends = [];

    const TYPE_CANCEL_ORDER = 'cancel_order'; // 取消订单

    const TYPE_PAY_ORDER = 'pay_order'; // 支付订单

    const TYPE_WITHDRAW = 'withdraw'; // 用户提现

    const TYPE_BACK_GOODS = 'back_goods'; // 退货

    const TYPE_ORDER_REBATE = 'order_rebate'; // 订单返现

    const TYPE_FIRST_REBATE = 'first_rebate'; // 一级粉丝返现

    const TYPE_SECOND_REBATE = 'second_rebate'; // 二级粉丝返现
}
