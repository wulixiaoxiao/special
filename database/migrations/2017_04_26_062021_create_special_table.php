<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special', function (Blueprint $table){
            $table->increments('id');
            $table->string('title')->default('')->comment('专题标题');
            $table->string('subtitle')->default('')->comment('专题副标题');
            $table->string('description')->default('')->comment('专题描述');
            $table->integer('category_id')->default(0)->comment('分类id');
            $table->integer('likes')->default(0)->comment('点赞数');
            $table->integer('comments')->default(0)->comment('评论数');
            $table->integer('sort_order')->default(0)->comment('排序');
            $table->string('goodids')->default('')->comment('关联商品id');
            $table->integer('is_recommend')->default(0)->comment('是否推荐');
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
        Schema::dropIfExists('special');
    }
}
