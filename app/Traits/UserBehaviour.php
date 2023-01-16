<?php

namespace App\Traits;
use Illuminate\Support\Facades\Auth;

trait UserBehaviour
{
    public function hasPermissions($permission_name){
        try{
    
          $hasAccess = Auth::user()->hasPermission($permission_name);
          return $hasAccess;
    
        }catch(\Exception $ex){
          throw $ex;
        }
      }
}