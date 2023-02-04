<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;


class CreateExpensesReportMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $procedure = "DROP PROCEDURE IF EXISTS `monthly_expenses_report`;
        CREATE PROCEDURE `monthly_expenses_report`()
   
        BEGIN
        
        SELECT DATE_FORMAT(date_of_expenditure, '%m-%Y') AS month_year, year(date_of_expenditure) AS year,  Month(date_of_expenditure) as month_int, MonthNAME(date_of_expenditure)  as month, sum(amount) as total FROM expenses
         group by month_year, year, month_int, month ORDER BY month_int, year DESC;

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
        DB::statement("DROP PROCEDURE IF EXISTS `monthly_expenses_report`");


    }
}
