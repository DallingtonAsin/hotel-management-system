<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id');
            $table->double('amount');
            $table->Date('date_of_expenditure');
            $table->boolean('is_deleted')->default(false);
            $table->unsignedBigInteger('recorded_by')->unsigned();
            $table->timestamps();

            $table->foreign('type_id')->references('id')->on('expense_types')->onDelete('cascade');
            $table->foreign('recorded_by')->references('id')->on('staff')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}
