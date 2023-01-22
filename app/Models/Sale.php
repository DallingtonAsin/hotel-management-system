<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;
    protected $table = 'sales';
    protected $fillable = [
        'item_id',
        'quantity',
        'selling_price',
        'total_cost',
        'discount',
        'amount',
        'customer',
        'date_of_sale',
        'cashier_id'
    ];
    public $timestamps = true;
}
