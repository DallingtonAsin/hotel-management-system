<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guest_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('discount_percent');
            $table->decimal('total_price');
            $table->integer('created_by')->unsigned();
            $table->timestamps();
            $table->foreign('guest_id')->references('id')->on('guests');
            $table->foreign('created_by')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('reservations');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
