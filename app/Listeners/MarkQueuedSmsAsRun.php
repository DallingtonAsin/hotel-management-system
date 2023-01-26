<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SMSNotifier;
use App\Events\SmsQueued;
use App\Models\Staff;

class MarkQueuedSmsAsRun
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
     * @param  SmsQueued  $event
     * @return void
     */
    public function handle(SmsQueued $QueuedSms)
    {
      $data = $QueuedSms->sms;

      $from = $data['from'];
      $to = $data['to'];
      $message = $data['message'];
      $created_at = $data['created_at'];

      //$this->MarkSMSAsQueued($from, $to, $created_at);
      $usersToBeNotified = $this->GetUsersToNotify($from);
      $notified = Notification::send($usersToBeNotified,
                  new SMSNotifier($data));

    }


    protected function MarkSMSAsQueued($sendertel, $receivertel, $created_at)
    {
        $date = date('Y-m-d', strtotime($created_at));
        $time = date('H:i:s', strtotime($created_at));
        $createdAt = date('Y-m-d H:i:s', strtotime($created_at));
        DB::select('exec MarkSMSAsQueued(?,?,?)', array($sendertel, $receivertel,$createdAt));
    }

    protected function GetUsersToNotify($sendertel)
    {
        $user = Staff::where('tel_no', $sendertel)->get();
        return $user;
    }




}
