<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->string('invoice_number');
            $table->unsignedBigInteger('reservation_id');
            $table->decimal('discount_percent')->default(0);
            $table->decimal('amount',8 , 2);
            $table->decimal('tax',8 , 2);
            $table->decimal('total_amount', 8, 2)->storedAs('amount + tax');
            $table->timestamp('ts_issued');
            $table->integer('issued_by')->unsigned();
            $table->integer('cancelled_by')->unsigned()->nullable();
            $table->timestamp('ts_paid')->nullable();
            $table->timestamp('ts_cancelled')->nullable();
            $table->timestamps();

            $table->index('invoice_number');
            $table->foreign('issued_by')->references('id')->on('staff');
            $table->foreign('cancelled_by')->references('id')->on('staff');
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('invoice_guests');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
