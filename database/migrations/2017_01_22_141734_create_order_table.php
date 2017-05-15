<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('member_id')->comment('会员ID');
            $table->string('order_sn')->comment('订单编号');
            $table->integer('order_price')->comment('订单总金额,以分为单位');
            $table->integer('goods_price')->comment('商品总金额,以分为单位');
            $table->integer('freight_price')->comment('运费金额,以分为单位');
            $table->integer('goods_number')->comment('订单产品总数量');
            $table->integer('goods_weight')->comment('订单产品总重量');
            $table->integer('pay_price')->comment('订单支付金额,以分为单位');
            $table->tinyInteger('pay_type')->comment('支付类型(1:余额,2:微信,3:支付宝)');
            $table->string('pay_number')->nullable()->comment('支付流水号');
            $table->integer('pay_time')->nullable()->comment('支付时间');
            $table->tinyInteger('is_pay')->comment('是否支付(1:是,0:否)');
            $table->string('order_note')->nullable()->comment('订单备注');
            $table->integer('status')->comment('订单状态(0：已取消，1：待付款，2：待发货，3：待确认，4.已完成)');
            $table->unsignedInteger('member_address_id')->comment('收货地址ID');
            $table->unsignedInteger('express_id')->comment('快递公司ID');
            $table->string('tracking_number')->nullable()->comment('快递单号');
            $table->tinyInteger('is_rebate')->comment('是否返利(1:是,0:否)');
            $table->integer('create_time')->nullable()->comment('订单生成时间');
            $table->integer('deliver_time')->nullable()->comment('订单发货时间');
            $table->integer('receiving_time')->nullable()->comment('订单收货时间');
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
        Schema::dropIfExists('order');
    }
}
