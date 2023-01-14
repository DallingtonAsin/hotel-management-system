<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KitchenOrder extends Model
{
    use HasFactory;

    protected $table = 'kitchen_orders';
    public $timestamps = true;

    protected $fillable = [
        'order_number',
        'table_number',
        'room_id',
        'guest_id',
        'customer_name',
        'phone_number',
        'tin_number',
        'email',
        'status',
        'order_date',
        'created_by'
    ];

}
