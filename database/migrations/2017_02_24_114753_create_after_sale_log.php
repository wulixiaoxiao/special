<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAfterSaleLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('after_sale_log', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('admin_id')->comment('管理员ID');
            $table->unsignedInteger('after_sale_id')->comment('售后ID');
            $table->string('service_number')->comment('服务单号');
            $table->tinyInteger('status')->comment('审核状态');
            $table->string('status_note')->comment('审核留言');
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
        Schema::dropIfExists('after_sale_log');
    }
}
