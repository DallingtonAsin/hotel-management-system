<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';
    public $timestamps = true;

    protected $fillable = [
        'guest_id',
        'guest_type_id',
        'room_id',
        'occupancy_type',
        'arrival_date',
        'departure_date',
        'discount_percent',
        'total_price',
        'created_by'
    ];
}