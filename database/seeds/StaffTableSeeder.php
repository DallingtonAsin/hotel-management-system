<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class StaffTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Staff::factory()->count(10)->create();

    }
}
