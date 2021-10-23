<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateBestsellingitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {

        // SQL SERVER QUERY

        // DB::statement("CREATE VIEW bestsellingitems AS 
        //     select TOP 20 item,sum(s.quantity) AS quantity, sum(s.amount)
        //      AS totalsales from sales as s
        //   group by item order by sum(s.amount) desc ");

          // MYSQL SERVER QUERY

          DB::statement("CREATE OR REPLACE VIEW bestsellingitems AS 
          select item,sum(`quantity`) AS quantity, sum(`amount`)
           AS totalsales, (round(sum(`amount`)/sum(`quantity`),2))
            AS saleqtyratio from sales
        group by item order by sum(`amount`) desc limit 20");
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         DB::statement('DROP VIEW IF EXISTS bestsellingitems');
    }
}
