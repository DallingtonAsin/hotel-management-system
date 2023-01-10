<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->double('subtotal', 10, 2);
            $table->double('tax', 10, 2);
            $table->double('total', 10, 2);
            $table->string('status');
            $table->timestamps();
            $table->foreign('order_number')->references('order_number')->on('kitchen_orders')->onDelete('cascade');

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
