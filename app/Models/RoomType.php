<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $table = 'room_types';
    public $timestamps = true;
    protected $fillable = [
      'id',
      'name',
      'single_occupancy_rate',
      'double_occupancy_rate',
      'added_by',
    ];
}
