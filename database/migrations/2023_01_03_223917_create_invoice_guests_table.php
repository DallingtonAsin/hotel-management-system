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
            $table->unsignedBigInteger('reservation_id');
            $table->decimal('discount_percent')->default(0);
            $table->decimal('total',8 , 2);
            $table->timestamp('ts_issued');
            $table->integer('issued_by')->unsigned();
            $table->integer('cancelled_by')->unsigned()->nullable();
            $table->timestamp('ts_paid')->nullable();
            $table->timestamp('ts_cancelled')->nullable();
            $table->timestamps();

            $table->foreign('issued_by')->references('id')->on('users');
            $table->foreign('cancelled_by')->references('id')->on('users');
            $table->foreign('reservation_id')->references('id')->on('reservations');

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
