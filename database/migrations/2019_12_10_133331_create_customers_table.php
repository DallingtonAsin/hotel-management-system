<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Customer;
use Carbon\Carbon;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact');
            $table->unsignedBigInteger('item_taken');
            $table->double('debt')->nullable();
            $table->double('credit')->nullable();
            $table->string('created_by');
            $table->date('taken_on')->nullable();
            $table->timestamps();
            $table->foreign('item_taken')->references('id')->on('stock')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('customers');
       DB::statement('DROP TABLE IF EXISTS customers');

    }
}
