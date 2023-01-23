<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateRoomStatusHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_status_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('status_id');
            $table->timestamp('changed_at');
            $table->unsignedBigInteger('changed_by')->unsigned();
            $table->timestamps();
          
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->foreign('changed_by')->references('id')->on('staff');
            $table->foreign('status_id')->references('id')->on('room_statuses');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_status_history');
    }
}
