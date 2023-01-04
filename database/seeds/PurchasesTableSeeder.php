<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class PurchasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Purchase::factory()->count(10)->create();


    }
}
