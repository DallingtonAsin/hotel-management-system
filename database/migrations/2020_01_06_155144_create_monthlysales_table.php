<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;


class CreateMonthlysalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        // DB::statement("CREATE VIEW monthlysales AS
        // select date_format(`date`,'%m-%Y') AS `month_year`, 
        // month(`date`) AS month_int,
        // monthname(`date`) AS month, year(`date`) AS year,
        // sum(`amount`) AS sales_made from `sales` 
        // group by month_year,month_int,month,year order by year asc")

        // DB::statement("CREATE VIEW monthlysales AS
        // select Month(s.date) AS 'month_int',FORMAT(s.date, 'MMMM', 'en-US') AS 'month',
        //  year(s.date) AS 'year',sum(s.amount) AS [sales_made] from sales as s
        //  GROUP BY 'month_int' order by sum(s.amount),year(s.date) desc offset 0 rows ");
    

        // SQL SERVER
        //    DB::statement("CREATE VIEW monthlysales AS SELECT YEAR(date) as SalesYear,
        //     MONTH(date) as SalesMonth,SUM(amount) AS TotalSales FROM sales
        //     GROUP BY YEAR(date), MONTH(date)
        //     ORDER BY MONTH(date), YEAR(date) desc offset 0 rows");

            // MYSQL SERVER

                DB::statement("CREATE OR REPLACE VIEW monthlysales AS
                select 
                date_format(`date`,'%m-%Y') AS `month_year`, 
                year(`date`) AS SalesYear,
                month(`date`) AS month_int,
                monthname(`date`) AS SalesMonth, 
                sum(`paid_amount`) AS TotalSales from `sales` 
                group by month_year,month_int, SalesMonth, SalesYear order by SalesYear desc");

// DB::statement("CREATE OR REPLACE VIEW monthlysales AS
// select 
// date_format(sales.date,'%m-%Y') AS month_year, 
// year(sales.date) AS SalesYear,
// month(sales.date) AS month_int,
// monthname(sales.date) AS SalesMonth, 
// sum(paid_amount) AS TotalSales
// ,sum(purchases.total_cost_price) AS TotalPurchases
// from sales, purchases
// group by month_year,month_int, SalesMonth, SalesYear order by SalesYear desc");






}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS monthlysales');

    }
}
