<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_images', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('goods_sku_id')->comment('商品规格ID');
            $table->tinyInteger('type')->default(2)->comment('图片类型(1:缩略图,2:商品图片)');
            $table->string('img_url')->comment('图片路径');
            $table->integer('sort_order')->default(0)->comment('排序');
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
        Schema::dropIfExists('goods_images');
    }
}
