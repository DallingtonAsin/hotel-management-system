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
        CREATE PROCEDURE `monthly_accomodation_revenue_report`(IN `year` VARCHAR(4))
   
        BEGIN

        SET @year = year;

        IF LENGTH(@year) > 1 THEN 

        select date_format(`paid_on`,'%m-%Y') AS `month_year`, 
        year(`paid_on`) AS year,
        month(`paid_on`) AS month_int,
        monthname(`paid_on`) AS month, 
        sum(`total_amount`) AS revenue from `reservation_invoices` where status='paid' AND year(`paid_on`)=@year 
        group by month_year,month_int, month, year order by month_int asc;


        ELSE

        select date_format(`paid_on`,'%m-%Y') AS `month_year`, 
        year(`paid_on`) AS year,
        month(`paid_on`) AS month_int,
        monthname(`paid_on`) AS month, 
        sum(`total_amount`) AS revenue from `reservation_invoices` where status='paid'
        group by month_year,month_int, month, year order by month_int, year desc;


        END IF;

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
        // DB::statement("DROP PROCEDURE IF EXISTS `monthly_accomodation_revenue_report`");
    }
}
