<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AdminLog
 *
 * @property int $id
 * @property int $admin_id 管理员ID
 * @property string $description 日志描述
 * @property string $sql 执行的sql语句
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdminLog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdminLog whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdminLog whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdminLog whereSql($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdminLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdminLog whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Admin $admin
 * @property-read mixed $admin_name
 */
class AdminLog extends Model
{
    use BaseModelTrait;

    protected $table = 'admin_log';
    protected $guarded = ['id'];
    protected $appends = ['admin_name'];

    public function admin() {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public function getAdminNameAttribute() {
        return $this->admin()->value('admin_name');
    }

    public function addLog($description) {
        AdminLog::create([
            'admin_id' => \Auth::guard('admin')->user()->id,
            'description' => $description,
            'sql' => json_encode(\DB::getQueryLog()),
        ]);
    }
}
