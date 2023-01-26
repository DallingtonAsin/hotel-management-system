<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_order_items', function (Blueprint $table) {

            $table->id();
            $table->string('order_number');
            $table->unsignedBigInteger('item_id');
            $table->integer('quantity');
            $table->double('price', 10, 2);
            $table->timestamps();

            $table->foreign('order_number')->references('order_number')->on('sales_orders')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('stock')->onDelete('cascade');
    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_order_items');
    }
}
