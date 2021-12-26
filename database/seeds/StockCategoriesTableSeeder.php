<?php

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
        factory(App\Models\StockCat::class, 10)->create();
    }
}
