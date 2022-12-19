<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Auth\Access\Response;
use App\Models\Department;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
      $this->registerPolicies();


      Gate::define('isSuperAdmin', function($user){

        $arr = $this->getPermissions($user->department_id);
        $permitX = $arr['isAdmin'];
        $permitY = $arr['isSuperAdmin'];
 
        if($permitX == 1 && $permitY == 1){
         return true;
       }
       return false;
     });

      Gate::define('isAdmin', function($user){

       $arr = $this->getPermissions($user->department_id);
       $permitX = $arr['isAdmin'];
       $permitY = $arr['isSuperAdmin'];

       if($permitX == 1 && $permitY == 0){
        return true;
      }
      return false;
    });

      Gate::define('isCashier', function($user){

       $arr = $this->getPermissions($user->department_id);
       $permitX = $arr['isAdmin'];
       $permitY = $arr['isSuperAdmin'];

       if($permitX == 0 && $permitY == 0){
        return true;
      }
      else{
        return false;
      }

    });


      Gate::define('isLogMaster', function($user){

        return ($user->role == 'Administrator')
        ? Response::allow()
        : Response::deny('Sorry,you must be a super administrator to delete logs.');
      });

      Gate::define('is_active',function($user){
        return ($user->approved == 1)?
        Response::allow() : Response::deny('Your account is inactive, please 
          inform your super administrator');
      });


      Gate::define('update-event', function ($user, $event_registra) {
        if($user->name == $event_registra){
          return true;
        }
        return false;
      });


      Gate::define('delete-event', function ($user, $event_registra) {
        if($user->name == $event_registra){
          return true;
        }
        return false;
      });

    }

    public function getPermissions($department_id){

      $isAdmin = 1;
      //  DB::table('departments')
      // ->where('id', $department_id)
      // ->value('is_admin');

      $isSuperAdmin = 0;
      //  DB::table('departments')
      // ->where('id', $department_id)
      // ->value('is_SuperAdmin');

      $dataArr = array(
        'isAdmin' => $isAdmin,
        'isSuperAdmin' => $isSuperAdmin,
      );

      return $dataArr;

    }

    protected function getUserRole($id)
    {
      $department = Department::where('id',$id)->value('name');
      return Str::singular($department);
    }

  }
