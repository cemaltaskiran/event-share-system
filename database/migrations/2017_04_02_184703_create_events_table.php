<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('city');
            $table->string('place');
            $table->unsignedInteger('quota')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('finish_date');
            $table->dateTime('last_attendance_date');
            $table->dateTime('publication_date');
            $table->unsignedInteger('status');
            $table->string('age_restriction')->nullable();
            $table->unsignedInteger('attendance_price')->nullable();
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
        Schema::dropIfExists('events');
    }
}
