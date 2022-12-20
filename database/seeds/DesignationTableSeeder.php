<?php

// namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Designation;

class DesignationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Designation::create([
            "name" => "Manager",
            "created_by" => "Olivia",
        ]);

        Designation::create([
            "name" => "Office Assistant",
            "created_by" => "Olivia",
        ]);

        Designation::create([
            "name" => "Cashier",
            "created_by" => "Olivia",
        ]);

        Designation::create([
            "name" => "House Keeper",
            "created_by" => "Olivia",
        ]);

        Designation::create([
            "name" => "Receiptionist",
            "created_by" => "Olivia",
        ]);

        Designation::create([
            "name" => "Computer Assistant",
            "created_by" => "Olivia",
        ]);
    }
}
