<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\LogicHandler;
use App\Models\Sales;
use App\User;
use App\Models\Role;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ReportsCron::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(\Jorijn\LaravelSecurityChecker\Console\SecurityMailCommand::class)
        ->weekly();

        $schedule->command("command:send-sales-made")
                         ->everyMinute()->withoutOverlapping();
                //   ->dailyAt('20:30')->withoutOverlapping();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

}
