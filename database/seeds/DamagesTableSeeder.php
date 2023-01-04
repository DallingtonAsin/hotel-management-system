<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DamagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \App\Models\Damage::factory()->count(10)->create();

    }
}
