<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('order_number')->unique();
            $table->string('table_number')->nullable();
            $table->unsignedBigInteger('room_id')->nullable();
            $table->unsignedBigInteger('guest_id')->nullable();
            $table->enum('status', ['In Progress', 'Completed', 'Cancelled']);
            $table->date('order_date');
            $table->integer('created_by')->unsigned();
            $table->timestamps();

            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('set null');
            $table->foreign('guest_id')->references('id')->on('guests')->onDelete('set null');
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
         Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['order_number']);
        });
        Schema::dropIfExists('orders');
    }
}
