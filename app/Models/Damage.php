<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Damage extends Model
{
    protected $table = 'damages';
    public $timestamps = false;
    protected $fillable = [
      'item',
      'item_id',
      'quantity',
      'category',
      'buying_price',
    ];
}
