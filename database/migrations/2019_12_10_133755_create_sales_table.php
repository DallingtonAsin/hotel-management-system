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


        // DB::statement("CREATE TABLE sales(
        //     id BIGINT PRIMARY KEY IDENTITY,
        //     item_id NVARCHAR(255),
        //     item NVARCHAR(255) NOT NULL,
        //     quantity FLOAT NOT NULL,
        //     original_price money NOT NULL,
        //     selling_price money NOT NULL,
        //     total_cost AS quantity * selling_price PERSISTED,
        //     discount money DEFAULT 0,
        //     amount money NOT NULL,
        //     customer NVARCHAR(50),
        //     date DATE NOT NULL,
        //     time TIME NOT NULL,
        //     cashier NVARCHAR(50) NOT NULL,
        //  )");

        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('item_id')->nullable();
            $table->string('item');
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
            $table->date('date');
            $table->time('time');
            $table->string('cashier', 45);
            $table->string('workedon_by')->nullable();
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
