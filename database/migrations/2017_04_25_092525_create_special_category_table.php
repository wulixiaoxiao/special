<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_category', function (Blueprint $table){
            $table->increments('id');
            $table->string('category_name')->default('')->comment('专题分类名称');
            $table->integer('sort_order')->default(0)->comment('专题分类名称');
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
        Schema::dropIfExists('special_category');
    }
}
