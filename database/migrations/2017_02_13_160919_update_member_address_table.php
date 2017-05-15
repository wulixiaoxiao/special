<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMemberAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_address', function (Blueprint $table) {
            $table->string('province')->change();
            $table->string('city')->change();
            $table->string('area')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_address', function (Blueprint $table) {
            $table->integer('province')->change();
            $table->integer('city')->change();
            $table->integer('area')->change();
        });
    }
}
