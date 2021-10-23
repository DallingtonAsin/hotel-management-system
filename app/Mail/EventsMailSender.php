<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventsMailSender extends Mailable
{
    use Queueable, SerializesModels;
    protected $MailData;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->MailData = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

          return $this->markdown('pages.mail.mail_event')
                      ->subject($this->MailData['subject'])
                      ->with([
                        'subject' => $this->MailData['subject'],
                        'title' => $this->MailData['title'],
                        'description' => $this->MailData['description'],
                        'start_date' => $this->MailData['start_date'],
                        'time' => $this->MailData['time'],
                        'end_date' => $this->MailData['end_date'],
                        'registra' => $this->MailData['registra'],
                        'registraMobileNo' => $this->MailData['registraMobileNo'],
                        'registra_email' => $this->MailData['registra_email'],
                  ]);
     
  }






}
