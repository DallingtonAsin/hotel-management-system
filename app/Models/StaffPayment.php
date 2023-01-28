<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PaymentCategory;

class StaffPayment extends Model
{
    use HasFactory;

    public function paymentCategory(){
        return $this->belongsTo(PaymentCategory::class);
    }

}
