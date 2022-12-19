<?php

// namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        Department::create([
            "name" => "Restaurant and Bar",
            "created_by" => "Olivia",
        ]);

        Department::create([
            "name" => "Human Resource",
            "created_by" => "Olivia",
        ]);

        Department::create([
            "name" => "Store",
            "created_by" => "Olivia",
        ]);

        Department::create([
            "name" => "House Keeping",
            "created_by" => "Olivia",
        ]);

        Department::create([
            "name" => "Accomodation",
            "created_by" => "Olivia",
        ]);

        Department::create([
            "name" => "Finance & Accounting",
            "created_by" => "Olivia",
        ]);
    }
}
