<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriorityEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('priority_events', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('event_id')->references('id')->on('events')->onUpdate('cascade')->onDelete('cascade');            
            $table->dateTime('finish_time');
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
        Schema::dropIfExists('priority_events');
    }
}
