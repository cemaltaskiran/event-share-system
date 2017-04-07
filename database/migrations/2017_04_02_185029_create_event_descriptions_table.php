<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_descriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('event_id')->references('id')->on('events')->onDelete('cascade')->onUpdate('cascade');
            $table->longText('description')->nullable();
            $table->string('footnote')->nullable();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_descriptions');
    }
}
