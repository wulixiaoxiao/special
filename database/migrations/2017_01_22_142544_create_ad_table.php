<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ad_position_id')->comment('广告位置ID');
            $table->string('ad_name')->comment('广告名称');
            $table->string('title')->comment('标题');
            $table->string('pic')->comment('广告图片路径');
            $table->string('link')->comment('广告链接');
            $table->integer('sort_order')->default(0)->comment('排序');
            $table->tinyInteger('is_show')->default(0)->comment('是否显示');
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
        Schema::dropIfExists('ad');
    }
}
