<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('goods_category_id')->comment('商品分类ID');
            $table->string('goods_name')->comment('商品名称');
            $table->string('goods_description')->nullable()->comment('商品描述');
            $table->integer('goods_weight')->default(0)->comment('商品重量,以克为单位');
            $table->integer('goods_margin')->default(0)->comment('商品毛利,以分为单位');
            $table->integer('market_price')->default(0)->comment('市场价格,以分为单位');
            $table->integer('selling_price')->default(0)->comment('实际价格,以分为单位');
            $table->integer('stock')->default(0)->comment('库存数');
            $table->integer('sort_order')->default(0)->comment('商品排序');
            $table->text('goods_detail')->nullable()->comment('商品详情');
            $table->tinyInteger('is_free_shipping')->default(0)->comment('是否包邮(1:是,0:否)');
            $table->tinyInteger('is_online')->default(0)->comment('是否上架(1:是,0:否)');
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
        Schema::dropIfExists('goods');
    }
}
