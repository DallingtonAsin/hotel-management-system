<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class StockCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\StockCat::factory()->count(15)->create();

    }
}
