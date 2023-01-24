<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('efris_code')->unique();
            $table->string('country')->unique();
            $table->double('rate');
            $table->text('description')->nullable();
            $table->boolean('is_deleted')->default(false);
             $table->unsignedBigInteger('created_by')->unsigned();
            $table->timestamps();

            $table->index('code');
            $table->index('efris_code');
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
        Schema::dropIfExists('currencies');
    }
}
