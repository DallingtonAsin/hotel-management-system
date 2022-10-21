<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use App\Models\Event;


class DeletePastEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:delPastEvents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'clears all events that have occurred already from the system';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
     $events = Event::whereDate('start_date', '<', now()->subDays(10))->delete();
    }
}
