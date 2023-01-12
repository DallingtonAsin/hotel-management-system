<?php

namespace App\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\QueuedEmail;
use App\Events\EmailQueued;
use App\Mail\SendMail;
use App\Staff;

class SendingEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $dataArr;
    protected $emailArr;
    protected $attachments; // = array();

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $fileAttachments)
    {
      $this->dataArr = $data;
      $this->emailArr =  $this->dataArr['receiverEmail'];
      $desc =  $this->dataArr['writing'];
      $this->attachments = $fileAttachments;

    //   for($i=0; $i<count($fileAttachments); $i++){
    //      $this->attachments[$i] = $fileAttachments[$i];
    //   }

    }

    /**
     * Execute the job.
     *C
     * @return void
     */
    public function handle()
    {
         $mail = (new SendMail($this->dataArr,$this->attachments)); //->onQueue('email');
        
         if(count($this->emailArr) > 0){
            for($i=0; $i<count($this->emailArr); $i++){
                $this->MailToUser($this->emailArr[$i], $mail);
                event(new EmailQueued($this->dataArr));
             }
        }
    }

    public static function SaveInQueuedMails($data, $email, $desc){

        try{
            $obj = new QueuedEmail();
            $obj->received_data = $data;
            $obj->email= $email;
            $obj->description = Hash::make($desc);
            $obj->save();
        }catch(\Exception $ex){
            dd($ex->getMessage());
        }

    }


    protected function MailToUser($UserEmail, $mailable)
    {
        Mail::to($UserEmail)->send($mailable);
    }


}
