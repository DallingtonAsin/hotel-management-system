<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('guest_id');
            $table->string('invoice_number');
            $table->decimal('amount', 8, 2);
            $table->string('method'); 
            $table->date('date'); 
            $table->integer('created_by')->unsigned();
            $table->timestamps();

            $table->foreign('guest_id')->references('id')->on('guests');
            $table->foreign('invoice_number')->references('invoice_number')->on('reservation_invoices');
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
        Schema::dropIfExists('payments');
    }
}
