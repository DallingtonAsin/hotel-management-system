<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FrequentContact;

class FrequentContactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         FrequentContact::factory()->count(25)->create();

    }
}
