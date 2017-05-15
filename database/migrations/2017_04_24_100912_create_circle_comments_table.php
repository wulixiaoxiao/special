<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCircleCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('circle_comments', function (Blueprint $table){
            $table->increments('id');
            $table->integer('member_id')->comment('评论人id');
            $table->integer('reply_id')->default(0)->comment('回复id');
            $table->integer('circle_id')->comment('动态id');
            $table->string('comment')->comment('评论内容');
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
        //
    }
}
