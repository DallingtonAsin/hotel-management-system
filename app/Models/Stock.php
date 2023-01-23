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
		'category_id',
		'quantity',  
		'buying_price',
		'selling_price',
		'wholesale_price',
		'supplier_id',
		'expiry_date',
		'created_by',
		'is_deleted'
	];

	public $timestamps = true; 
}
