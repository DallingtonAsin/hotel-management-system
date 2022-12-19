<?php

namespace App\Providers;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\EmailQueued;

class MarkQueuedEmailAsRun
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EmailQueued  $event
     * @return void
     */
    public function handle(EmailQueued $event)
    {
        //
    }
}
