<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KitchenOrderInvoice extends Model
{
    use HasFactory;

    // Fillable fields
    protected $fillable = ['kitchen_order_id', 'invoice_total', 'paid_at'];

    // Relationships
    public function kitchenOrder()
    {
        return $this->belongsTo('App\Models\KitchenOrder');
    }

}
