<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
	use HasFactory;
	protected $table = 'stock';

	protected $fillable = [
		'item_code',
		'item_name',
		'goods_type_code',
	    'stockin_type_code',
		'quantity',  
		'buying_price',
		'selling_price',
		'supplier_id',
		'expiry_date',
		'remarks',
		'created_by',
		'is_deleted'
	];

	public $timestamps = true; 

	public function increase($quantity)
    {
        $this->quantity += $quantity;
        return $this->save();
    }

	public function decrease($quantity)
    {
        $this->quantity -= $quantity;
        return $this->save();
    }
}
