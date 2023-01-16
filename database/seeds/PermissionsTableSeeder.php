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


      $permissions = config('permissions');
      foreach($permissions as $key => $permission){
         Permission::create([
            'name' => $permission
         ]);
      }

    }
}
