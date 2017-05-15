<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_comment', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('member_id')->comment('会员ID');
            $table->unsignedInteger('order_id')->comment('订单ID');
            $table->unsignedInteger('goods_id')->comment('商品ID');
            $table->string('content')->comment('评论内容');
            $table->tinyInteger('is_show')->default(1)->comment('是否显示(1:显示,0:隐藏,默认显示)');
            $table->integer('create_time')->comment('添加时间');
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
        Schema::dropIfExists('goods_comment');
    }
}
