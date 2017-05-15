<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsGrandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_brand', function (Blueprint $table) {
            $table->increments('id');
            $table->string('goods_brand_name')->comment('商品品牌名称');
            $table->integer('sort_order')->default(0)->comment('排序');
            $table->tinyInteger('is_show')->default(0)->comment('是否显示');
            $table->string('description')->default('')->comment('商品品牌介绍');
            $table->string('logo')->default('')->comment('商品品牌LOGO');
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
        Schema::dropIfExists('goods_brand');
    }
}
