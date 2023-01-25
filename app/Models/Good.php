<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    use HasFactory;


    protected $table = 'goods';
    public $timestamps = true;
    
    protected $fillable = [
        'goods_name',
        'goods_code',
        'measure_unit',
        'unit_price',
        'currency_id',
        'commodity_category_id',
        'have_excise_tax',
        'description',
        'stock_prewarning',
        'price_measure_unit',
        'have_piece_unit',
        'piece_unit_price',
        'package_scaled_value',
        'piece_scaled_value',
        'excise_duty_code',
        'have_other_unit',
        'goods_type_code',
        'goods_other_units',
        'created_by'
    ];
}
