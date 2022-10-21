<?php 

namespace App\Facades;

use LaravelDaily\Invoices\Classes\InvoiceItem;

class InvoiceItemExtended extends InvoiceItem {
    
    public function __construct(){
        
    }
    
    public function description($str){
        return $str;
    }
    
    
}