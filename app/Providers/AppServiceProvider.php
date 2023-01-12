<?php

namespace App\Providers;
use App\Staff;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; 
use Illuminate\Support\Facades\Queue; 
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use App\Http\View\Composers\ComposerNotifications;
use App\Http\View\Composers\ComposerOverview;
use App\Http\View\Composers\ComposerGlobals;
use App\Models\Company;

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


        // $company = Company::where('company_name', '!=', null)->first();
 
    //    //Option1: Every single view
        // View::share('companyData', $company);


       //Option2: View Composer you can attach data to specific views
       // View::composer(['pages.main.suppliers','pages.main.customers'], function($view){
       //   $user = Staff::find(1);
       //   $messages = array();
       //   foreach ($user->notifications as $notification) {
       //     $rows = $notification->data;
       //     $messages  = array($rows);
       //   }
       //   $view->with('type', $messages);
       // });


     //Option3: Dedicated class
     View::composer(['pages.*'], ComposerNotifications::class);
     View::composer(['pages.*'], ComposerOverview::class);
    //  View::composer(['pages.*'], ComposerGlobals::class);
     
     




    }
}
