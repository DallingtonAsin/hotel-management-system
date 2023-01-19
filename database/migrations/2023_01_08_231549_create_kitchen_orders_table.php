<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateKitchenOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kitchen_orders', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('order_number')->unique();
            $table->string('table_number')->nullable();
            $table->unsignedBigInteger('room_id')->nullable();
            $table->unsignedBigInteger('guest_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('tin_number')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->enum('status', ['in progress', 'completed', 'cancelled']);
            $table->timestamp('order_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('created_by')->unsigned();
            $table->timestamps();

            $table->foreign('room_id')->references('id')->on('rooms');
            $table->foreign('guest_id')->references('id')->on('guests');
            $table->foreign('created_by')->references('id')->on('staff');
            $table->index('order_number');
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
        Schema::table('kitchen_orders', function (Blueprint $table) {
            $table->dropIndex(['order_number']);
        });
        Schema::dropIfExists('kitchen_orders');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
       
    }
}
