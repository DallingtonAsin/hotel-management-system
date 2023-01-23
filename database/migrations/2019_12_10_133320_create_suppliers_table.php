<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('tin')->unique();
            $table->string('phone_number')->unique();
            $table->string('email')->nullable();
            $table->string('address');
            $table->double('debt')->nullable();
            $table->double('credit')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->unsignedBigInteger('created_by')->unsigned();

            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('staff');
            // $table->date('created_at')->default(Carbon::now());
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
        Schema::dropIfExists('suppliers');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
