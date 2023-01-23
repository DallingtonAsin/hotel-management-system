<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id');
            $table->string('number')->unique();
            $table->string('floor_number');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('status_id');
             $table->unsignedBigInteger('created_by')->unsigned();
            $table->timestamps();
            $table->foreign('type_id')->references('id')->on('room_types');
            $table->foreign('status_id')->references('id')->on('room_statuses');
            $table->foreign('created_by')->references('id')->on('staff');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
