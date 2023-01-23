<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); 
            $table->unsignedBigInteger('created_by')->unsigned();
            $table->boolean('is_deleted')->default(false);
            $table->timestamps(); 
            
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
        Schema::dropIfExists('stock_categories');
    }
}
