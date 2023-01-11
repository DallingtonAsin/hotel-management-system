<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KitchenMenuItemCategory extends Model
{
    use HasFactory;

    protected $table = 'kitchen_menu_item_categories';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'created_by'
    ];
}
