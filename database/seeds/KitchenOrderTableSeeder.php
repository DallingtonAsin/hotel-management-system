<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KitchenOrder;

class KitchenOrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KitchenOrder::factory()->count(100)->create();

    }
}
