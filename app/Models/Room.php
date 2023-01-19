<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RoomStatus;
use App\Models\RoomStatusHistory;

class Room extends Model
{
    protected $table = 'rooms';
    public $timestamps = true;

    protected $fillable = [
      'type_id',
      'number',
      'floor_number',
      'status_id',
      'description',
      'created_by',
    ];

    public function status()
    {
        return $this->belongsTo(RoomStatus::class, 'status_id');
    }

    public function statusHistory()
    {
        return $this->hasMany(RoomStatusHistory::class);
    }
}
