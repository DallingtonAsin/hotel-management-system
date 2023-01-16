<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StaffPermission;

class StaffPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StaffPermission::create([
            'permission_id' => 1,
            'staff_id' => 1
         ]);

         StaffPermission::create([
            'permission_id' => 1,
            'staff_id' => 2
         ]);

         StaffPermission::create([
            'permission_id' => 2,
            'staff_id' => 1
         ]);

         StaffPermission::create([
            'permission_id' => 2,
            'staff_id' => 2
         ]);

         StaffPermission::create([
            'permission_id' => 3,
            'staff_id' => 1
         ]);

         StaffPermission::create([
            'permission_id' => 3,
            'staff_id' => 2
         ]);

         StaffPermission::create([
            'permission_id' => 4,
            'staff_id' => 1
         ]);

         StaffPermission::create([
            'permission_id' => 4,
            'staff_id' => 2
         ]);

         StaffPermission::create([
            'permission_id' => 5,
            'staff_id' => 1
         ]);

         StaffPermission::create([
            'permission_id' => 5,
            'staff_id' => 2
         ]);

         StaffPermission::create([
            'permission_id' => 6,
            'staff_id' => 1
         ]);

         StaffPermission::create([
            'permission_id' => 6,
            'staff_id' => 2
         ]);

         StaffPermission::create([
            'permission_id' => 7,
            'staff_id' => 1
         ]);

         StaffPermission::create([
            'permission_id' => 7,
            'staff_id' => 2
         ]);

         StaffPermission::create([
            'permission_id' => 8,
            'staff_id' => 1
         ]);

         StaffPermission::create([
            'permission_id' => 8,
            'staff_id' => 2
         ]);

         StaffPermission::create([
            'permission_id' => 9,
            'staff_id' => 1
         ]);
    }
}
