<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateReservationInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->unsignedBigInteger('reservation_id');
            $table->decimal('discount_percent')->default(0);
            $table->decimal('amount',8 , 2);
            $table->decimal('tax',8 , 2);
            $table->decimal('total_amount', 8, 2)->storedAs('amount + tax');
            $table->timestamp('issued_on')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedBigInteger('issued_by')->unsigned();
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->timestamp('paid_on')->nullable();
            $table->string('payment_method')->nullable();
            $table->unsignedBigInteger('completed_by')->unsigned()->nullable();
            $table->timestamp('cancelled_on')->nullable();
            $table->string('cancelled_for')->nullable();
            $table->unsignedBigInteger('cancelled_by')->unsigned()->nullable();
            $table->timestamps();

            $table->index('invoice_number');
            $table->foreign('issued_by')->references('id')->on('staff');
            $table->foreign('completed_by')->references('id')->on('staff');
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
        Schema::dropIfExists('reservation_invoices');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
