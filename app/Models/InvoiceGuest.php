<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reservation;

class InvoiceGuest extends Model
{
    use HasFactory;

    protected $table = 'invoice_guests';
    public $timestamps = true;

    protected $fillable = [
        'invoice_number',
        'reservation_id',
        'discount_percent',
        'amount',
        'tax',
        'total_amount',
        'ts_issued',
        'issued_by',
        'cancelled_by',
        'ts_paid',
        'ts_cancelled'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
