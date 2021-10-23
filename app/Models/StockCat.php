<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockCat extends Model
{
    protected $table = 'stockcategories';
    public $timestamps = false;
    protected $fillable = [
      'item_category'
    ];
}
