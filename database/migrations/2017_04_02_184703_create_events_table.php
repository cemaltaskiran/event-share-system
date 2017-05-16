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
            $table->unsignedInteger('city_id')->references('code')->on('cities')->onUpdate('cascade')->onDelete('cascade');
            $table->string('place');
            $table->dateTime('start_date');
            $table->dateTime('finish_date');
            $table->dateTime('last_attendance_date');
            $table->dateTime('publication_date');
            $table->text('description');
            $table->string('footnote')->nullable();
            $table->unsignedInteger('status');
            $table->unsignedInteger('quota')->nullable();
            $table->string('age_restriction')->nullable();
            $table->unsignedInteger('attendance_price')->nullable();
            $table->unsignedInteger('eventable_id');
            $table->string('eventable_type');
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
