<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'sales';
    protected $fillable=['id', 'item', 'quantity', 'selling_price', 
                          'total_cost', 'discount','amount', 'customer', 
                          'date_of_sale,cashier'];
    public $timestamps = false;
}
