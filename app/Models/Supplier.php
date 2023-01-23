<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
  use HasFactory;
  protected $table = 'suppliers';
  protected $fillable = [
    'name',
    'tin',
    'phone_number',
    'email',
    'address',
    'debt',
    'credit',
    'is_deleted',
    'created_by'
  ];
  public $timestamps = true;
}
