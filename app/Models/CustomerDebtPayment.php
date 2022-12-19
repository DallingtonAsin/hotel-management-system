<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerDebtPayment extends Model
{
    protected $table = "customer_debt_payments";
    protected $fillable = [
        'sale_id',
        'amount_paid',
        'balance',
        'date',
        'recorded_by'
    ];
    public $timestamps = true;

}
