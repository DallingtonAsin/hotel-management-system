<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->id();
            $table->string('goods_name', 200);
            $table->string('goods_code', 50)->unique();
            $table->string('measure_unit', 3);
            $table->double('unit_price');
            $table->unsignedBigInteger('currency_id');
            $table->unsignedBigInteger('commodity_category_id');
            $table->string('have_excise_tax', 3);
            $table->text('description')->nullable();
            $table->string('stock_prewarning', 24);
            $table->string('price_measure_unit', 3)->nullable();
            $table->string('have_piece_unit', 3);
            $table->double('piece_unit_price')->nullable();
            $table->double('package_scaled_value')->nullable();
            $table->double('piece_scaled_value')->nullable();
            $table->string('excise_duty_code', 20)->nullable();
            $table->string('have_other_unit', 3)->nullable();
            $table->string('goods_type_code', 3)->nullable();
            $table->text('goods_other_units', 1024)->nullable();
            $table->unsignedBigInteger('created_by')->unsigned();
            $table->timestamps();

            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('commodity_category_id')->references('id')->on('commodity_categories');
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
        Schema::dropIfExists('goods');
    }
}
