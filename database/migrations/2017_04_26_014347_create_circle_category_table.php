<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCircleCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('circle_category', function (Blueprint $table){
            $table->increments('id');
            $table->string('category_name')->default('')->comment('圈子分类名称');
            $table->integer('sort_order')->default(0)->comment('排序');
            $table->string('img_url')->default('')->comment('圈子分类图片');
            $table->string('description')->default('')->comment('描述');
            $table->integer('people_num')->default(0)->comment('圈子人数');
            $table->tinyInteger('is_show')->default(0)->comment('是否显示（1显示0不显示）');
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
        Schema::dropIfExists('circle_category');
    }
}
