<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Designation extends Model
{
   use HasFactory;
   protected $table = 'designations';
   public $timestamps = true;
   protected $fillable = [
   	        'id',
              'name',
              'department_id',
              'created_by'
   ];
}
