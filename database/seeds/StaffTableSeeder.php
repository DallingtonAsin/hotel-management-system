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
        Staff::where('id', 1)->update(['first_name' => 'Charity', 'last_name' => 'Manager', 'username' => 'admin']);
    }
}
