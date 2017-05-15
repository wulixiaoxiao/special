<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecommendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recommend', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('circle_id')->default(0)->comment('圈子内容id');
            $table->string('title')->default('')->comment('标题');
            $table->string('categroy_name')->default('')->comment('分类名称');
            $table->integer('length')->default(0)->comment('视频时长,单位秒');
            $table->string('video_url')->default('')->comment('视频地址');
            $table->integer('sort')->default(0)->comment('排序');
            $table->tinyInteger('is_show')->default(0)->comment('是否显示');
            $table->string('cover_img')->default(0)->comment('封面图');
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
        Schema::dropIfExists('recommend');
    }
}
