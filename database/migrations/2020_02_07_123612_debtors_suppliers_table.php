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

            DB::statement("CREATE OR REPLACE VIEW `debtors_suppliers` AS
            select `name` AS `name`,`phone_number` AS `phone_number`, sum(`debt`) AS `debts` 
            from `suppliers` group by `name`,`phone_number` 
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
