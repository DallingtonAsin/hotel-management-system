<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('stock', function (Blueprint $table) {
            $table->id();
            $table->string('item_code')->nullable();
            $table->string('item_name')->unique();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->double('quantity');
            $table->double('threshold_qty')->default('0');
            $table->double('buying_price');
            $table->double('selling_price');
            $table->double('wholesale_price')->default('0');
            $table->double('profit_per_item')->storedAs('selling_price-buying_price')->nullable();
            $table->double('total_cost_price')->storedAs('quantity*buying_price')->nullable();
            $table->double('total_profit')->storedAs('quantity*(selling_price-buying_price)')->nullable();
            $table->timestamp('date_of_entry')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->date('expiry_date')->nullable();
            $table->unsignedBigInteger('created_by')->unsigned();
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('category_id')->references('id')->on('stock_categories');
            $table->foreign('created_by')->references('id')->on('staff');

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
        Schema::dropIfExists('stock');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
       
    }
}
