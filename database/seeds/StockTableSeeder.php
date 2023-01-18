<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class StockTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Stock::factory()->count(180)->create();

    }
}
