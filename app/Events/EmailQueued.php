<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\QueuedEmail;

class EmailQueued
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $mail;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
       $this->mail = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new Channel('emails');
    }
}


# This event class is a container for the event instance that was queued.
