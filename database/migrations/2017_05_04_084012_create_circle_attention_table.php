<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCircleAttentionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('circle_attention', function (Blueprint $table) {
           $table->increments('id');
            $table->integer('member_id')->default(0)->comment('用户id');
            $table->integer('circle_category_id')->default(0)->comment('圈子分类id');
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
        Schema::dropIfExists('circle_attention');
    }
}
