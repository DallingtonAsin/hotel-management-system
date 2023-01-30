<?php

namespace App\Providers;

use App\Models\Staff;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Http\View\Composers\ComposerOverview;
use Illuminate\Support\Facades\Blade;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        View::composer(['*'], ComposerOverview::class);

        Blade::if('haspermission', function ($permission) {
            if (Auth::check()) {
                $staff = Staff::find(Auth::user()->id);
                return $staff->hasPermission($permission);
            } else {
                return view('auth.login');
            }
        });
    }
}
