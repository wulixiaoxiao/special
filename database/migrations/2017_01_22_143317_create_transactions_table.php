<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->comment('类型，确定target_id是哪个表的数据');
            $table->integer('target_id')->comment('目标id,根据type确定');
            $table->unsignedInteger('member_id')->comment('会员ID');
            $table->integer('money')->default(0)->comment('金额(以分为单位)');
            $table->integer('balance')->default(0)->comment('用户余额(以分为单位)');
            $table->string('description')->nullable()->comment('描述');
            $table->integer('create_time')->default(0)->comment('生成时间');
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
        Schema::dropIfExists('transactions');
    }
}
