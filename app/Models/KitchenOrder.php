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
        'item',
        'quantity',
        'status',
        'created_by'
    ];


}
