<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Staff;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data, $fileContents;
    protected $fileAttachments;
    /**
    * Create a new message instance.
    *
    * @return void
    */
    public function __construct($dataParas, $attachments)
    {
        $this->data = $dataParas;
        $this->fileAttachments = $attachments;
        }
        
        /**
        * Build the message.
        *
        * @return $this
        */
        public function build()
        {
            
            $emailArr = $this->data['receiverEmail'];
            if(count($emailArr) > 0){
                for($i=0; $i<count($emailArr); $i++){
                    $receiver  = $this->GetNameForUser($emailArr[$i]);
                    $this->MailDownEmail($emailArr[$i], $receiver);
                }
            }
            
        }
        
        
        protected function MailDownEmail($receiverEmail, $receiver)
        {
            
            
            
            if(is_array($this->fileAttachments) && count($this->fileAttachments) > 0)
            {
                $mailable = $this->markdown('pages.mail.sendings.email')
                ->subject($this->data['subject'])
                ->with(['content' => $this->data]);

                for($i=0; $i<count($this->fileAttachments); $i++){
                    
                    $attachmentPath = $this->fileAttachments[$i][0];   
                    $attachmentName = $file = $this->fileAttachments[$i][1];
                    $attachmentMime = $this->fileAttachments[$i][2];
                    
                   $exists = Storage::disk('public')->exists($file);
                   if($exists){
                        
                        $file_path = Storage::disk('public')->get($file);
                        
                        $this->fileContents = base64_encode($file_path);
                        $mailable->attachData(base64_decode($this->fileContents), 
                        $attachmentName,
                        ['mime' => $attachmentMime]);
                     
                        Storage::disk('public')->delete($file);
                  }
                       
                }
                return $mailable;
                
            }
            else{
                
                $mailable =  $this->markdown('pages.mail.sendings.email')
                ->subject($this->data['subject'])
                ->with(['content' => $this->data]);
                return $mailable;
                
            }
            
            
            
            
        }
        
        
        protected function GetNameForUser($email)
        {
            $names = Staff::where('email', $email)->value('name');
            return $names;
        }
        
        
    }
