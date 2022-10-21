<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
  protected $table = 'taxes';
  public $timestamps = true;
  protected $fillable = [
    'tax_name',
    'tax_percentage'
  ];
}
