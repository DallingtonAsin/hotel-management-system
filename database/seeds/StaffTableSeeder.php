<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Staff;

class StaffTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Staff::factory()->count(15)->create();
        Staff::where('id', 1)->update(['first_name' => 'Rogers', 'last_name' => 'Manager', 'username' => 'admin', 'designation_id' => 1]);
        Staff::where('id', 2)->update(['first_name' => 'Francis', 'last_name' => 'Agaba', 'username' => 'agaba']);
        Staff::where('id', 3)->update(['first_name' => 'Guest', 'last_name' => 'Test001', 'username' => 'test001']);


    }
}
