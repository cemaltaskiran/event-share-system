<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizerContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizer_contact', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('organizer_id')->references('id')->on('organizers')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('contact_type_id')->references('id')->on('contact_types');
            $table->string('value');
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
        Schema::dropIfExists('organizer_contact');
    }
}
