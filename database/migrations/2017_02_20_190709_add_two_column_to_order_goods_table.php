<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTwoColumnToOrderGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_goods', function(Blueprint $table) {
            $table->tinyInteger('is_free_shipping')->comment('是否免邮');
            $table->integer('goods_margin')->comment('商品毛利');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_goods', function(Blueprint $table) {
            $table->dropColumn('is_free_shipping');
            $table->dropColumn('goods_margin');
        });
    }
}
