<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KitchenMenuItem extends Model
{
    use HasFactory;
    
    protected $table = 'kitchen_menu_items';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'discount_percent',
        'price',
        'category'
    ];

}
