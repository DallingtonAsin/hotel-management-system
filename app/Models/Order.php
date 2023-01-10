<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    public $timestamps = true;
    
    protected $fillable = [
        'order_number',
        'table_number',
        'room_id',
        'guest_id',
        'status',
        'order_date',
        'created_by',
    ];

}
