<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsCollectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_collection', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('member_id')->comment('会员ID');
            $table->unsignedInteger('goods_id')->comment('商品ID');
            $table->integer('create_time')->comment('添加时间');
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
        Schema::dropIfExists('goods_collection');
    }
}
