<?php 

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class PermissionService
{
    public function hasPermission($permissionName)
    {
        try{
            return Auth::user()->hasPermission($permissionName);

        }catch(\Exception $ex){
            throw $ex;
        }
        
    }
}