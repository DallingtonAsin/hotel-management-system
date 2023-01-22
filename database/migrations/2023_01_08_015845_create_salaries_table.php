<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->unsigned();
            $table->decimal('amount', 8, 2); 
            $table->date('pay_date');
            $table->boolean('is_deleted')->default(false);
             $table->unsignedBigInteger('created_by')->unsigned();
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('staff');
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
        Schema::dropIfExists('salaries');
    }
}