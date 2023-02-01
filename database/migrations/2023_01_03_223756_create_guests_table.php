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
            $table->string('last_name')->nullable();
            $table->string('phone_number');
            $table->string('email')->nullable();
            $table->string('job_title')->nullable();
            $table->string('tin_number')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_contact')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_tin')->nullable();
            $table->string('nationality')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('nin')->nullable();
            $table->date('card_issue_date')->nullable();
            $table->date('card_expiry_date')->nullable();
             $table->unsignedBigInteger('created_by')->unsigned();
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('guests');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
