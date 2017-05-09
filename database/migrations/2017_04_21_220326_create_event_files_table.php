<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_files', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('event_id')->references('id')->on('events')->onDelete('cascade')->onUpdate('cascade');
            $table->binary('file');
            $table->unsignedInteger('file_type_id')->references('id')->on('file_types')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE event_files MODIFY COLUMN file MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_files');
    }
}
