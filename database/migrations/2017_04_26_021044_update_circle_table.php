<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCircleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('circle', function (Blueprint $table){
            $table->string('tag')->default('')->comment('标签');
            $table->integer('category_id')->default(0)->comment('分类名称');
            $table->string('coordinate')->default('')->comment('位置');
            $table->integer('length')->default(0)->comment('视频时长，单位秒');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('circle', function (Blueprint $table){
            $table->dropColumn('tag');
            $table->dropColumn('category_id');
        });
    }
}
