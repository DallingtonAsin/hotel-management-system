<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\DataTables\HR\StaffMembersDataTable;

class StaffDataTableServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('StaffMembersDataTable', function () {
            return new StaffMembersDataTable();
            });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
