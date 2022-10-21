<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
	protected $table = 'stock';

	protected $fillable = [
		'item_code',
		'item',
		'category',
		'quantity',  
		'buying_price',
		'selling_price',
		'wholesale_price',
		'supplier',
		'expiry_date',
	];

	public $timestamps = true; 
}
