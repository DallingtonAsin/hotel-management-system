<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateCustomerDebtPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_debt_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sale_id');
            $table->double('amount_paid');
            $table->double('balance');
            $table->date('date');
            $table->integer('created_by')->unsigned();
            $table->timestamps();
        });

        Schema::table('customer_debt_payments', function($table){
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('customer_debt_payments');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
