<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateKitchenOrderInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kitchen_order_invoices', function (Blueprint $table) {
          
            $table->id();
            $table->string('order_number');
            $table->double('sub_total', 10, 2);
            $table->double('tax', 10, 2);
            $table->double('total', 10, 2);
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->timestamp('issued_on')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('paid_at')->nullable();
            $table->string('payment_method')->nullable();
            $table->integer('completed_by')->unsigned()->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->string('cancelled_for')->nullable();
            $table->integer('cancelled_by')->unsigned()->nullable();


            $table->timestamps();
            $table->foreign('order_number')->references('order_number')->on('kitchen_orders')->onDelete('cascade');
            $table->foreign('completed_by')->references('id')->on('staff');
            $table->foreign('cancelled_by')->references('id')->on('staff');

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
        Schema::dropIfExists('kitchen_order_invoices');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
