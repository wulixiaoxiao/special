<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AfterSaleLog
 *
 * @property int $id
 * @property int $admin_id 管理员ID
 * @property int $after_sale_id 售后ID
 * @property int $service_number 服务单号
 * @property bool $status 审核状态
 * @property string $status_note 审核留言
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSaleLog whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSaleLog whereAfterSaleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSaleLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSaleLog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSaleLog whereServiceNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSaleLog whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSaleLog whereStatusNote($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSaleLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AfterSaleLog extends Model
{
    use BaseModelTrait;

    protected $table = 'after_sale_log';

    protected $guarded = ['id'];
}
