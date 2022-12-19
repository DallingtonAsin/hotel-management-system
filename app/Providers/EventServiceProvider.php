<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\EmailQueued;
use App\Listeners\MarkQueuedEmailAsRun;
use App\Events\SmsQueued;
use App\Listeners\MarkQueuedSmsAsRun;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
            Registered::class => [
              SendEmailVerificationNotification::class,
            ],
            EmailQueued::class => [
                MarkQueuedEmailAsRun::class,
            ],
            SmsQueued::class => [
                MarkQueuedSmsAsRun::class,
            ],

            'Illuminate\Mail\Events\MessageSending' => [
                'App\Listeners\LogSendingMessage',
            ],
            'Illuminate\Mail\Events\MessageSent' => [
                'App\Listeners\LogSentMessage',
            ],
           
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
