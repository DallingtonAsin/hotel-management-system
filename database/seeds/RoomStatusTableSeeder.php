<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoomStatus;

class RoomStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        RoomStatus::create([
            'name' => 'Available',
            'created_by' => 1
        ]);

        RoomStatus::create([
            'name' => 'Occupied',
            'created_by' => 1
        ]);

        RoomStatus::create([
            'name' => 'Cleaned',
            'created_by' => 1
        ]);

        RoomStatus::create([
            'name' => 'Under Maintenance',
            'created_by' => 1
        ]);
    }
}
