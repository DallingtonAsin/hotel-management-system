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
            $table->string('item_name');
            $table->string('item_code');
            $table->string('goods_type_code');
            $table->string('stockin_type_code');
            $table->unsignedBigInteger('supplier_id');
            $table->double('quantity');
            $table->double('threshold_qty')->nullable()->default('0');
            $table->double('buying_price');
            $table->double('selling_price');
            $table->double('profit_per_item')->storedAs('selling_price-buying_price');
            $table->double('total_cost_price')->storedAs('quantity*buying_price');
            $table->double('total_profit')->storedAs('quantity*(selling_price-buying_price)');
            $table->timestamp('date_of_entry')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->date('expiry_date')->nullable();
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('created_by')->unsigned();
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();


            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('item_code')->references('goods_code')->on('goods');
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
