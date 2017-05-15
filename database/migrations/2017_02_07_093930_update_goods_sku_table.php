<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGoodsSkuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goods_sku', function(Blueprint $table) {
            $table->renameColumn('sku_values', 'sku_value_ids');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('goods_sku', function(Blueprint $table) {
            $table->renameColumn('sku_value_ids', 'sku_values');
        });
    }
}
