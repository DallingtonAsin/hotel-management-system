<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
           'name' => 'view_rooms'
        ]);
        Permission::create([
            'name' => 'create_rooms'
         ]);
         Permission::create([
            'name' => 'update_rooms'
         ]);
         Permission::create([
            'name' => 'delete_rooms'
         ]);
         Permission::create([
            'name' => 'view_bookings'
         ]);
         Permission::create([
            'name' => 'create_bookings'
         ]);
         Permission::create([
            'name' => 'update_bookings'
         ]);
         Permission::create([
            'name' => 'cancel_bookings'
         ]);
         Permission::create([
            'name' => 'view_guests'
         ]);
         Permission::create([
            'name' => 'create_guests'
         ]);
         Permission::create([
            'name' => 'update_guests'
         ]);
         Permission::create([
            'name' => 'delete_guests'
         ]);
         Permission::create([
            'name' => 'view_reports'
         ]);
         Permission::create([
            'name' => 'manage_users'
         ]);


    }
}
