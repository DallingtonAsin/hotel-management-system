<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateMonthlyPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW monthly_purchases AS
        select 
        date_format(`date_of_purchase`,'%m-%Y') AS `month_year`, 
        year(`date_of_purchase`) AS purchase_year,
        month(`date_of_purchase`) AS month_int,
        monthname(`date_of_purchase`) AS month_name, 
        sum(`total_cost_price`) AS total_purchases from `purchases` 
        group by month_year,month_int, month_name, purchase_year order by purchase_year desc");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS monthly_purchases');
    }
}
