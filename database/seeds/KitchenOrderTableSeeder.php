<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KitchenOrder;
use Illuminate\Support\Facades\DB;

class KitchenOrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        KitchenOrder::factory()->count(235)->create();

        $orders = KitchenOrder::get();
        foreach($orders as $order){
            DB::update(
                "UPDATE kitchen_orders SET order_date=DATE_FORMAT(order_date,'2023-%m-%d %T')"
            );
        }

    }
}
