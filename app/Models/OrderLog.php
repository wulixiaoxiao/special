<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderLog
 *
 * @property int $id
 * @property int $admin_id 管理员ID
 * @property int $order_id 订单ID
 * @property string $description 描述
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderLog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderLog whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderLog whereOrderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderLog whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderLog whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Order $order
 * @property-read mixed $admin_name
 */
class OrderLog extends Model
{
    use BaseModelTrait;

    protected $table = 'order_log';

    protected $guarded = ['id'];

    protected $appends = ['admin_name'];

    public function order() {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function getAdminNameAttribute() {
        if ($this->admin_id <= 0) { return ''; }
        return Admin::whereId($this->admin_id)->value('admin_name');
    }

    /**
     * 添加订单日志
     *
     * @param $orderId
     * @param $description
     * @param int $adminId
     */
    public function addLog($orderId, $description, $adminId = 0) {
        OrderLog::create([
            'admin_id' => $adminId,
            'order_id' => $orderId,
            'description' => $description,
        ]);
    }
}
