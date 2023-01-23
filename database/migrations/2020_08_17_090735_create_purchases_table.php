<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('serial_no')->nullable();
            $table->string('receipt_no')->nullable();
            $table->string('item_code')->nullable();
            $table->string('item_name')->nullable();
            $table->float('quantity');
            $table->double('cost_price_per_item');
            $table->double('total_cost_price')->storedAs('quantity * cost_price_per_item');
            $table->double('retail_price')->default('0');
            $table->double('wholesale_price')->default('0');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->string('created_by');
            $table->date('date_of_purchase')->default(Carbon::now());
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('suppliers');

        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
