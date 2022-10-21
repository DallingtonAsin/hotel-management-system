<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Exports\DailySalesReport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Excel as BaseExcel;
use Maatwebsite\Excel\Facades\Excel;


class DailySalesReportMailSender extends Mailable
{
    use Queueable, SerializesModels;
    protected $data;
  
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dataToSend)
    {
        $this->data = $dataToSend;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      
    try{

    $excelFile = Excel::download(new DailySalesReport, 'daily-sales-report.xlsx');
    return $this->markdown('pages.mail.sales.dailyReport')
    ->subject($this->data['subject'])
    ->with([
        'subject' => $this->data['subject'],
        'amount' => $this->data['amount'],
        'email' => $this->data['email'],
        'totl_sold' => $this->data['totl_no'],
        'netValue' => $this->data['netValue'],
         ])->attach($excelFile->getFile(), ['as' => 'daily-sales-report.xlsx']);

         Log::channel('poslogs')->notice("I have sent email to ".$this->data['email']."");

    }
        catch(\Exception $ex){
            \Log::info("Exception encountered and it is ".$ex->getMessage());
        }

    }


}
