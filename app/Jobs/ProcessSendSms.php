<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Support\Facades\Hash;
use App\Models\SMS;
use App\Events\SmsQueued;

class ProcessSendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sms;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
       $this->sms = $data;
       $this->SaveInQueuedSMS($this->sms);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $from = $this->sms['from'];
        $to = $this->sms['to'];
        $text_message = $this->sms['message'];
        $bool = $this->SendTextMessage($from, $to, $text_message);
        if($bool == true){
            //fire an event
            event(new SmsQueued($this->sms));
        }
    }
 
  protected function SendTextMessage($from, $receiver, $message)
  {
    // Call API Nexmo
    $nexmo = app('Nexmo\Client');
    $result = $nexmo->message()->send([
           'to' => $receiver,
           'from' => $from,
           'text' => $message,
    ]);
    ($result)
    ? $isSent = true
    : $isSent = false;

    return $isSent;

  }

  
  protected function SaveInQueuedSMS($data){

    $obj = new SMS;
    $obj->sender_telno = $data['from'];
    $obj->receiver_telno = $data['to'];
    $obj->message = Hash::make($data['message']);
    $obj->save();
}
  






}
