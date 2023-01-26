<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommodityCategory extends Model
{
    use HasFactory;

    protected $table = 'commodity_categories';
    public $timestamps = true;
    
    protected $fillable = [
        'name',
        'code',
        'is_deleted',
        'created_by'
    ];

}
