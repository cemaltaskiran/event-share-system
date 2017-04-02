<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentReputationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_reputations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('comment_id')->references('id')->on('comments');
            $table->unsignedInteger('user_id')->references('id')->on('users');
            $table->boolean('is_good');
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
        Schema::dropIfExists('comment_reputations');
    }
}
