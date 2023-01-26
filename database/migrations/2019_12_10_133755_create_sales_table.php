<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->double('quantity');
            $table->double('original_price');
            $table->double('selling_price');
            $table->double('total_buying_cost')->storedAs('quantity * original_price');
            $table->double('total_cost')->storedAs('quantity * selling_price');
            $table->double('discount');
            $table->double('amount');
            $table->double('paid_amount');
            $table->double('balance')->default(0);
            $table->double('extra_money')->default(0);
            $table->boolean('is_credit')->default('0');
            $table->boolean('fully_paid')->default('1');
            $table->string('customer')->nullable();
            $table->double('tax')->default('0');
            $table->timestamp('date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedBigInteger('cashier_id')->unsigned();
            $table->timestamps();

            $table->foreign('item_id')->references('id')->on('stock');
            $table->foreign('cashier_id')->references('id')->on('staff');
        });
       


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('sales');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
