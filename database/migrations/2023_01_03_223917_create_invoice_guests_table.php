<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_guests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guest_id');
            $table->unsignedBigInteger('reservation_id');
            $table->foreign('guest_id')->references('id')->on('guests');
            $table->foreign('reservation_id')->references('id')->on('reservations');
            $table->timestamp('ts_issued');
            $table->timestamp('ts_paid')->nullable();
            $table->timestamp('ts_cancelled')->nullable();
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
        Schema::dropIfExists('invoice_guests');
    }
}
