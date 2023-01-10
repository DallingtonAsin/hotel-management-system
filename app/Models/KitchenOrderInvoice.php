<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KitchenOrderInvoice extends Model
{
    use HasFactory;


    protected $table = 'kitchen_order_invoices';
    public $timestamps = true;

    // Fillable fields
    protected $fillable = ['order_number', 'subtotal', 'tax', 'total', 'status'];

    // Relationships
    public function kitchenOrder()
    {
        return $this->belongsTo('App\Models\KitchenOrder');
    }

}
