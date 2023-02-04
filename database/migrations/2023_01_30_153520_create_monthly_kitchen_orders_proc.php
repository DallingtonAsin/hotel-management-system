<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;


class CreateMonthlyKitchenOrdersProc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        $procedure = "DROP PROCEDURE IF EXISTS `monthly_kitchen_orders`;
        CREATE PROCEDURE `monthly_kitchen_orders`(IN `order_status` VARCHAR(30))
   
        BEGIN
        
        SET @order_status = order_status;
        
        IF LENGTH(order_status) < 1 THEN 

                   select date_format(`order_date`,'%m-%Y') AS `month_year`, 
                year(`order_date`) AS `year`,
                month(`order_date`) AS `month_int`,
                monthname(`order_date`) AS `month`, 
                count(`id`) AS total from `kitchen_orders` 
                group by `month_year`,`month_int`, `month`, `year` order by `month_int`, `year` desc;
            

        ELSE
        
         select date_format(`order_date`,'%m-%Y') AS `month_year`, 
                year(`order_date`) AS `year`,
                month(`order_date`) AS `month_int`,
                monthname(`order_date`) AS `month`, 
                `status`, count(`id`) AS `total` from `kitchen_orders` WHERE `status` COLLATE utf8mb4_unicode_ci LIKE CONCAT('%', @order_status, '%')
                group by `month_year`,`month_int`, `month`, `status`, `year` order by `month_int`, `year` desc;


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
        DB::statement("DROP PROCEDURE IF EXISTS `monthly_kitchen_orders`");
    }
}
