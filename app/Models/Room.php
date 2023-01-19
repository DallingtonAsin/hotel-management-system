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
      'status_id',
      'description',
      'created_by',
    ];

    public function statusHistory()
    {
        return $this->hasMany(RoomStatusHistory::class);
    }
}
