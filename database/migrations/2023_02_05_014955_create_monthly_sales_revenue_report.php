<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateMonthlySalesRevenueReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "DROP PROCEDURE IF EXISTS `monthly_sales_revenue_report`;
        CREATE PROCEDURE `monthly_sales_revenue_report`()
   
        BEGIN
        
        select date_format(`date`,'%m-%Y') AS `month_year`, 
                year(`date`) AS year,
                month(`date`) AS month_int,
                monthname(`date`) AS month, 
                sum(`paid_amount`) AS total from `sales` 
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
        DB::statement("DROP PROCEDURE IF EXISTS `monthly_sales_revenue_report`");

    }
}
