<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAfterSaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('after_sale', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('member_id')->comment('会员ID');
            $table->unsignedInteger('order_id')->comment('订单ID');
            $table->unsignedInteger('order_goods_id')->comment('订单商品ID');
            $table->integer('goods_number')->comment('商品数量');
            $table->tinyInteger('type')->comment('售后类型(1:退货,2:返修)');
            $table->string('service_number')->comment('服务单号');
            $table->string('question')->comment('问题描述');
            $table->string('pic')->nullable()->comment('图片');
            $table->integer('apply_time')->comment('提交申请时间');
            $table->tinyInteger('status')->comment('状态(1:等待审核,2:审核通过，请寄送快递,3:审核不通过,4:已收到寄件，检测中,5:退换货成功,6:退换货失败)');
            $table->text('status_note')->nullbable()->comment('审核留言');
            $table->unsignedInteger('admin_id')->default(0)->comment('管理员ID');
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
        Schema::dropIfExists('after_sale');
    }
}
