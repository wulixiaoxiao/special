<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->increments('id');
            $table->string('admin_name')->comment('管理员账号');
            $table->string('admin_nickname')->comment('管理员昵称');
            $table->string('password')->comment('管理员密码');
            $table->string('remember_token')->nullable()->comment('记住我');
            $table->integer('create_time')->comment('注册时间');
            $table->integer('last_time')->comment('最后登录时间');
            $table->string('permissions')->nullable()->comment('权限组');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin');
    }
}
