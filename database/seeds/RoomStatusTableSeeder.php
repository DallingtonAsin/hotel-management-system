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

        $room_statuses = config('room-statuses');
        foreach($room_statuses as $status){
           RoomStatus::create([
            'name' => ucwords($status),
            'created_by' => 1
        ]);
        }

    }
}
