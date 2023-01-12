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
            $table->enum('status', ['In Progress', 'Completed', 'Cancelled']);
            $table->date('order_date');
            $table->integer('created_by')->unsigned();
            $table->timestamps();

            $table->foreign('room_id')->references('id')->on('rooms');
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
