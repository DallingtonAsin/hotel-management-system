<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InvoiceGuest;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';
    public $timestamps = true;
    protected $fillable = [
        'arrival_date',
        'departure_date',
        'room_id',
        'guest_id',
        'guest_type_id',
        'occupancy_type',
        'created_by'
    ];

    public function invoice()
    {
        return $this->hasOne(InvoiceGuest::class);
    }
}