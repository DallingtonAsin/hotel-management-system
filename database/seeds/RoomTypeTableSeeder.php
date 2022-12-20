<?php

// namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoomType;

class RoomTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RoomType::create([
            "name" => "Executive Suite",
            "single_occupancy_rate" => 300,
            "double_occupancy_rate" => 500,
            "added_by" => "Olivia",
        ]);

        RoomType::create([
            "name" => "Deluxe Suite",
            "single_occupancy_rate" => 250,
            "double_occupancy_rate" => 400,
            "added_by" => "Olivia",
        ]);

        RoomType::create([
            "name" => "Standard Suite",
            "single_occupancy_rate" => 100,
            "double_occupancy_rate" => 150,
            "added_by" => "Olivia",
        ]);

        RoomType::create([
            "name" => "Executive Room",
            "single_occupancy_rate" => 80,
            "double_occupancy_rate" => 100,
            "added_by" => "Olivia",
        ]);

        RoomType::create([
            "name" => "Deluxe Room",
            "single_occupancy_rate" => 70,
            "double_occupancy_rate" => 90,
            "added_by" => "Olivia",
        ]);

        RoomType::create([
            "name" => "Deluxe Double",
            "single_occupancy_rate" => 60,
            "double_occupancy_rate" => 80,
            "added_by" => "Olivia",
        ]);

        RoomType::create([
            "name" => "Standard Room",
            "single_occupancy_rate" => 50,
            "double_occupancy_rate" => 70,
            "added_by" => "Olivia",
        ]);
    }
}
