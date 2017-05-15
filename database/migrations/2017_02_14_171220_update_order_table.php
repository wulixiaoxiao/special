<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order', function(Blueprint $table) {
            $table->string('receiver_name')->comment('收货人姓名');
            $table->string('receiver_phone_number')->comment('收货人手机号码');
            $table->string('receiver_province')->comment('收货人身份');
            $table->string('receiver_city')->comment('收货人城市');
            $table->string('receiver_area')->comment('收货人区域');
            $table->string('receiver_detail')->comment('收货人详细地址');

            $table->integer('pay_price')->nullable()->change();
            $table->integer('pay_type')->nullable()->change();
            $table->unsignedInteger('express_id')->nullable()->change();

            $table->dropColumn('member_address_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order', function(Blueprint $table) {
            $table->dropColumn('receiver_name');
            $table->dropColumn('receiver_phone_number');
            $table->dropColumn('receiver_province');
            $table->dropColumn('receiver_city');
            $table->dropColumn('receiver_area');
            $table->dropColumn('receiver_detail');

            $table->integer('pay_price')->nullable(false)->change();
            $table->tinyInteger('pay_type')->nullable(false)->change();
            $table->unsignedInteger('express_id')->nullable(false)->change();

            $table->unsignedInteger('member_address_id')->comment('收货地址ID');
        });
    }
}
