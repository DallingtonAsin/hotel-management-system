<?php

// namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GuestType;

class GuestTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GuestType::create([
            "name" => "Regular",
            "is_regular" => true,
            "is_corporate" => false,
        ]);

        GuestType::create([
            "name" => "Walkin",
            "is_regular" => true,
            "is_corporate" => false,
        ]);

        GuestType::create([
            "name" => "Corporate",
            "is_regular" => false,
            "is_corporate" => true,
        ]);
    }
}
