<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Admin::truncate();
        \App\Models\Admin::create([
            'admin_name' => 'admin',
            'admin_nickname' => '超级管理员',
            'password' => md5('123456'),
            'permissions' => '',
            'create_time' => time(),
            'last_time' => 0,
        ]);
    }
}
