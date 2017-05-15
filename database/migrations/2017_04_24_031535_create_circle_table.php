<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCircleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('circle', function (Blueprint $table){
            $table->increments('id');
            $table->integer('member_id')->comment('作者id');
            $table->tinyInteger('type')->default(1)->comment('动态类型,1文字,2文字加图片,3文字加视频');
            $table->string('title')->default('')->comment('标题');
            $table->string('content')->default('')->comment('内容');
            $table->string('links')->default('')->comment('内容，图片链接或视频链接');
            $table->integer('likes')->default(0)->comment('点赞数');
            $table->integer('comments')->default(0)->comment('评论数');
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
        Schema::dropIfExists('circle');
    }
}
