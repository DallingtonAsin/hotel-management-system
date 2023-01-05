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
            $table->integer('issued_by')->unsigned();
            $table->unsignedBigInteger('paid_by')->nullable();
            $table->integer('cancelled_by')->unsigned();
            $table->timestamp('ts_issued');
            $table->timestamp('ts_paid')->nullable();
            $table->timestamp('ts_cancelled')->nullable();
            $table->timestamps();
            $table->foreign('issued_by')->references('id')->on('users');
            $table->foreign('cancelled_by')->references('id')->on('users');
            $table->foreign('paid_by')->references('id')->on('guests');


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
