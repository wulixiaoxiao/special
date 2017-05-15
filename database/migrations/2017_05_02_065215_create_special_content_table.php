<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_content', function (Blueprint $table){
            $table->increments('id');
            $table->integer('special_id')->default(0)->comment('专题id');
            $table->tinyInteger('sort')->default(0)->comment('内容排序');
            $table->tinyInteger('type')->default(0)->comment('类型，1图片2视频');
            $table->text('content')->comment('文字内容');
            $table->string('filePath')->default('')->comment('图片视频地址');
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
        Schema::dropIfExists('special_content');
    }
}
