<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';
    public $timestamps = true;
    protected $fillable = [
      'id',
      'code',
      'name',
      'created_by',
    ];
}
