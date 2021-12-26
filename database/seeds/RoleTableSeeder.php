<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Role::create(['role' => 'Cashier', 'is_admin' => 0, 'is_SuperAdmin' => 0]);
        Role::create(['role' => 'Administrator', 'is_admin' => 1, 'is_SuperAdmin' => 0]);

    }
}
