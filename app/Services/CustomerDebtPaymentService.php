<?php 

namespace App\Services;

use App\Models\CustomerDebtPayment;
use Auth;

class CustomerDebtPaymentService{

     public function recordPayment($data){
         $is_recorded = false;
          try{
               $payment = new CustomerDebtPayment();
               $payment->sale_id = $data['sale_id'];
               $payment->amount_paid = $data['amount_paid'];
               $payment->balance = $data['balance'];
               $payment->date = $data['date'];
               $payment->recorded_by = Auth::user()->id;
               if($payment->save()){
                 $is_recorded = true;
               }
               return $is_recorded;
          }catch(\Exception $e){
             throw $e;
          }

     }





}