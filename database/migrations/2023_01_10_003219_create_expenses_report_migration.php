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
        
        DB::unprepared('CREATE PROCEDURE IF NOT EXISTS getMonthlyExpensesReport()
        BEGIN
          SELECT DATE_FORMAT(date_of_expenditure, "%m-%Y") AS month_year, year(date_of_expenditure) AS year,  Month(date_of_expenditure) as month_int, MonthNAME(date_of_expenditure)  as month_name, sum(amount) as total FROM expenses group by month_year, year, month_int, month_name ORDER BY YEAR(date_of_expenditure) DESC, MONTH(date_of_expenditure) DESC;
        END');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE getMonthlyExpensesReport');

    }
}
