<?php

namespace App\Providers;

use App\Models\Staff;
use App\Models\Designation;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;


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

    Gate::define('is-cashier', function () {
      return $this->isCashier(Auth::user()->id);
    });
  }


  private function isCashier($user_id)
  {
    $user =  Staff::find($user_id);
    $designation = Designation::find($user->designation_id);
    $is_cashier = false;

    if (stripos($designation->name, 'cashier') !== false) {
      $is_cashier = true;
    }
    return $is_cashier;
  }
}
