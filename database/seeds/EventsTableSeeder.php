<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Event::factory()->count(10)->create();

        
    }
}
