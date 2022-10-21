<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Mail;
use App\Events\EmailQueued;
use App\Jobs\SendingEmail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use App\Notifications\NewEmailNotifier;
use App\Models\QueuedEmail;
use App\Mail\SendMail;
use App\User;

class MarkQueuedEmailAsRun
{

    // public $connection = "database";
    // public $queue = "email";
    // public $delay = 15;
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
    public function handle(EmailQueued $queuedMail){
       $emailArr = array();
        $data = $queuedMail->mail;
        foreach($data as $key => $value){
            if($key == 'receiverEmail'){
                foreach($value as $actualData){
                    array_push($emailArr, $actualData);
                }
                $created_at = $data['recordedOn'];
            }
        }

        if(count($emailArr) > 0){

            $notificationArr = $queuedMail->mail;
            $notificationArr['title'] = "New mail message from ".$notificationArr['senderName']."";
            $notificationArr['description'] = $notificationArr['writing'];
            $notificationArr['sender'] = $notificationArr['senderName'];

            for($i=0; $i<count($emailArr); $i++)
            {
               // $this->MarkQueuedMailAsRun($emailArr[$i], $created_at);
                $usersToBeNotified = $this->GetUsersToNotify($emailArr[$i]);
                $notified = Notification::send($usersToBeNotified,
                            new NewEmailNotifier($notificationArr));
             }
            }


    }

    protected function GetUsersToNotify($email)
       {
           $users = User::where('email', $email)->get();
           return $users;
       }

    protected function MarkQueuedMailAsRun($email, $created_at)
    {

        try{
        $date = date('Y-m-d', strtotime($created_at));
        $time = date('H:i', strtotime($created_at));
        $createdAt = date('Y-m-d H:i:s', strtotime($created_at));
        DB::select("exec MarkEmailAsRun(?,?)", array($email, $createdAt));
        }catch(\Exception $ex){
            dd($ex->getMessage());
        }


    }

}
