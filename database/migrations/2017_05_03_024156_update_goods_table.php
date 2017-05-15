<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goods', function (Blueprint $table){
            $table->tinyInteger('goods_brand_id')->default(0)->comment('商品所属品牌id');
            $table->string('tag')->default('')->comment('商品标签');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('goods', function (Blueprint $table){
            $table->dropColumn('goods_brand_id');
            $table->dropColumn('tag');
        });
    }
}
