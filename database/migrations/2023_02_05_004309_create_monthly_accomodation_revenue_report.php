<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateMonthlyAccomodationRevenueReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "DROP PROCEDURE IF EXISTS `monthly_accomodation_revenue_report`;
        CREATE PROCEDURE `monthly_accomodation_revenue_report`()
   
        BEGIN
        
        select date_format(`paid_at`,'%m-%Y') AS `month_year`, 
        year(`paid_at`) AS year,
        month(`paid_at`) AS month_int,
        monthname(`paid_at`) AS month, 
        sum(`total`) AS revenue from `kitchen_order_invoices` where status='paid'
        group by month_year,month_int, month, year order by month_int, year desc;
        
        END;";

        DB::statement($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP PROCEDURE IF EXISTS `monthly_accomodation_revenue_report`");
    }
}
