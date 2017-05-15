<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('')->comment('用户名');
            $table->string('avatar')->default('')->comment('头像');
            $table->string('signature')->default('')->comment('个性签名');
            $table->string('cover_img')->default('')->comment('个人主页封面图');
            $table->string('phone')->default('')->unique()->comment('手机号');
            $table->string('address')->default('')->comment('居住地');
            $table->string('balance')->default('')->comment('余额');
            $table->string('password')->default('')->comment('密码');
            $table->string('api_token')->default('')->comment('api令牌');
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
        Schema::dropIfExists('users');
    }
}
