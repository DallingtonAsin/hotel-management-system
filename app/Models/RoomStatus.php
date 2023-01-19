<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomStatus extends Model
{
    use HasFactory;

    protected $table = 'room_statuses';
    public $timestamps = true;

    protected $fillable = [
      'name',
      'created_by'
    ];
}
