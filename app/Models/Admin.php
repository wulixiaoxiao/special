<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\Admin
 *
 * @property int $id
 * @property string $admin_name 管理员账号
 * @property string $password 管理员密码
 * @property int $create_time 注册时间
 * @property int $last_time 最后登录时间
 * @property string $permissions 权限组
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereAdminName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereCreateTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereLastTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin wherePermissions($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $remember_token 记住我
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereRememberToken($value)
 * @property string $admin_nickname 管理员昵称
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereAdminNickname($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdminLog[] $adminLog
 */
class Admin extends Authenticatable
{
    use Notifiable,BaseModelTrait;

    protected $table = 'admin';
    protected $guarded = ['id'];

    public function adminLog() {
        return $this->hasMany(AdminLog::class, 'admin_id', 'id');
    }
}
