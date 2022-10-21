<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DebtorsSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // SQL SERVER QUERY
        // DB::statement("CREATE VIEW debtors_suppliers
        //  AS select s.name AS 'name',s.contact AS 'contact',
        //   sum(s.debt) AS 'debts' 
        //     from suppliers as s group by
        //      s.name,s.contact order by sum(s.debt) desc offset 0 rows ");

            DB::statement("CREATE OR REPLACE VIEW `debtors_suppliers` AS
            select `name` AS `name`,`contact` AS `contact`, sum(`debt`) AS `debts` 
            from `suppliers` group by `name`,`contact` 
            order by sum(`debt`) desc");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW debtors_suppliers');
   

    }
}
