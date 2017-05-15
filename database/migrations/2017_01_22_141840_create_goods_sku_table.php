<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsSkuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_sku', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('goods_id')->comment('商品ID');
            $table->string('sku_ids')->default(0)->comment('规格ID值组合');
            $table->string('sku_values')->nullable()->comment('规格属性值组合');
            $table->integer('market_price')->default(0)->comment('市场价格,以分为单位');
            $table->integer('selling_price')->default(0)->comment('实际价格,以分为单位');
            $table->integer('stock')->default(0)->comment('库存数');
            $table->tinyInteger('is_default')->default(0)->comment('是否默认规格(1:是,0否)');
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
        Schema::dropIfExists('goods_sku');
    }
}
