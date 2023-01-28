<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StaffPayment;

class PaymentCategory extends Model
{
    use HasFactory;
    protected $table = 'payment_categories';
	public $timestamps = true;

	protected $fillable = [
		'name',
		'transaction_type',
        'is_deleted',
		'created_by'
	];

    public function payments(){
        return $this->hasMany(StaffPayment::class);
    }

}
