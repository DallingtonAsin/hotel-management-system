<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\KitchenOrder;

class KitchenOrderItem extends Model
{
    use HasFactory;

    protected $table = 'kitchen_order_items';
    public $timestamps = true;

    // Fillable fields
    protected $fillable = ['order_number', 'item_id', 'quantity', 'price', 'total'];

    public function order(){
        $this->belongsTo(KitchenOrder::class, 'order_number');
    }

}
