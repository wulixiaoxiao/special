<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_goods', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id')->comment('订单ID');
            $table->unsignedInteger('goods_id')->comment('商品ID');
            $table->integer('goods_price')->comment('商品单价(单位:分)');
            $table->integer('goods_number')->comment('商品数量');
            $table->integer('goods_weight')->comment('商品重量(单位:克)');
            $table->unsignedInteger('sku_id')->nullable()->default(0)->comment('规格ID');
            $table->string('sku_str')->nullable()->comment('规格属性值组合');
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
        Schema::dropIfExists('order_goods');
    }
}
