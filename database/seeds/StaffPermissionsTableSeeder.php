<?php

namespace Database\Seeders;

use App\Models\Permission;
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

      $permissions = config('permissions');
      foreach($permissions as $key => $permission){
         $permission_id = Permission::where('name', $permission)->value('id');
         StaffPermission::create([
            'permission_id' => $permission_id,
            'staff_id' => 1
         ]);
      }

    }
}
