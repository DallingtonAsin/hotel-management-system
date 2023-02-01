<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reservation;

class ReservationInvoice extends Model
{
    use HasFactory;

    protected $table = 'reservation_invoices';
    public $timestamps = true;

    protected $fillable = [
        'invoice_number',
        'reservation_id',
        'discount_percent',
        'amount',
        'tax',
        'total_amount',
        'issued_on',
        'issued_by',
        'status',
        'payment_method',
        'completed_by',
        'cancelled_by',
        'paid_on',
        'cancelled_on'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

}
