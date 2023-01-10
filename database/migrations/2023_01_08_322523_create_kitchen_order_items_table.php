<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKitchenOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kitchen_order_items', function (Blueprint $table) {

            $table->id();
            $table->string('order_number');
            $table->unsignedBigInteger('item_id');
            $table->integer('quantity');
            $table->double('price', 10, 2);
            $table->double('total', 10, 2);
            $table->timestamps();

            $table->foreign('order_number')->references('order_number')->on('kitchen_orders')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('kitchen_menu_items')->onDelete('cascade');
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
        Schema::dropIfExists('kitchen_order_items');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
