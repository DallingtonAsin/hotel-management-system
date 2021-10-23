<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'purchases';

    protected $fillable = [
        'serial_no',
        'receipt_no',
        'item_id',
        'item',
        'quantity',
        'cost_price_per_item',
        'retail_price',
        'wholesale_price',
        'supplier',
        'supplier_contact',
        'recorded_by',
        'date',      
    ];
    public $timestamps = false;
}
