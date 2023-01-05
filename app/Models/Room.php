<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';
    public $timestamps = true;

    protected $fillable = [
      'type_id',
      'number',
      'floor_number',
      'status',
      'description',
      'created_by',
    ];
}
