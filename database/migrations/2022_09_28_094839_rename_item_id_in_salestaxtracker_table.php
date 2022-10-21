<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameItemIdInSalestaxtrackerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salestaxtracker', function (Blueprint $table) {
            $table->renameColumn('item_id', 'item_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salestaxtracker', function (Blueprint $table) {
            $table->renameColumn('item_id', 'item_code');
        });
    }
}
