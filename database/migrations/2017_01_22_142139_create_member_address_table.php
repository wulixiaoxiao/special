<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_address', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('member_id')->comment('会员ID');
            $table->string('name')->comment('姓名');
            $table->string('phone_number')->comment('手机号码');
            $table->integer('province')->comment('省份');
            $table->integer('city')->comment('城市');
            $table->integer('area')->comment('区域');
            $table->string('detail_address')->nullable()->comment('详细地址');
            $table->tinyInteger('is_default')->default(0)->comment('是否是默认(1:是,0:否,默认否)');
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
        Schema::dropIfExists('member_address');
    }
}
