<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PaymentCategory;

class StaffPayment extends Model
{
    use HasFactory;

    protected $table = 'staff_payments';

	protected $fillable = [
        'staff_id',
        'payment_category_id',
        'amount',
        'payment_date',
        'is_deleted',
        'created_by'
	];

    public $timestamps = true;
  
    public function paymentCategory(){
        return $this->belongsTo(PaymentCategory::class);
    }

}
