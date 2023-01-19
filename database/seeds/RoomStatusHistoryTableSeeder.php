<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoomStatusHistory;

class RoomStatusHistoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        RoomStatusHistory::factory()->count(10)->create();

    }
}
