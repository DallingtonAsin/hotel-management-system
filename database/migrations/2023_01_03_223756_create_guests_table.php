<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->unsignedBigInteger('guest_type_id');
            $table->string('email')->nullable();
            $table->string('phone_number');
            $table->string('address')->nullable();
            $table->string('details')->nullable();
            $table->integer('created_by')->unsigned();
            $table->timestamps();
            $table->foreign('guest_type_id')->references('id')->on('guest_types');
            $table->foreign('created_by')->references('id')->on('users');
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
        Schema::dropIfExists('guests');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
