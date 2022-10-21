<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory;
    protected $table = 'purchases';

    protected $fillable = [
        'serial_no',
        'receipt_no',
        'item_code',
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
    public $timestamps = true;
}
