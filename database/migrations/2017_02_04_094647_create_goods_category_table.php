<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('goods_category_name')->comment('商品分类名称');
            $table->integer('sort_order')->default(0)->comment('排序');
            $table->tinyInteger('is_show')->default(0)->comment('是否显示');
            $table->string('category_img')->default('')->comment('商品分类图片');
            $table->string('category_icon')->default('')->comment('分类图标');
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
        Schema::dropIfExists('goods_category');
    }
}
