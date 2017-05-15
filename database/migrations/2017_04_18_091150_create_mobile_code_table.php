<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_code', function (Blueprint $table) {
            $table->increments('id');
            $table->char('mobile', 11)->comment('手机号码');
            $table->integer('code')->comment('验证码');
            $table->string('type')->comment('验证码类型，详见model');
            $table->tinyInteger('status')->comment('是否已使用');
            $table->integer('num')->comment('发送次数');
            $table->integer('time')->comment('发送时间');
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
        Schema::dropIfExists('mobile_code');
    }
}
