<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKitchenMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kitchen_menu_items', function (Blueprint $table) {
           
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->double('price', 10, 2);
            $table->unsignedBigInteger('category_id');
            $table->boolean('is_deleted')->default(false);
             $table->unsignedBigInteger('created_by')->unsigned();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('kitchen_menu_item_categories');
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
        Schema::dropIfExists('kitchen_menu_items');
    }
}
