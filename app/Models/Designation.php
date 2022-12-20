<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Designation extends Model
{
   use HasFactory;
   protected $table = 'designations';
   public $timestamps = false;
   protected $fillable = [
   	        'id',
              'name',
   ];
}
