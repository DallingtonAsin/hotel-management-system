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
            $table->unsignedBigInteger('kitchen_order_id');
            $table->decimal('invoice_total', 8, 2);
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->foreign('kitchen_order_id')->references('id')->on('kitchen_orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kitchen_order_invoices');
    }
}
