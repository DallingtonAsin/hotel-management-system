<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';
    public $timestamps = true;
    protected $fillable = [
      'room_type_id',
      'room_number',
      'floor_number',
      'description',
      'added_by',
    ];
}
