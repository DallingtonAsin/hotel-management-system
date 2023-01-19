<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'room_status_history';
    public $timestamps = true;

    protected $fillable = [
        'room_id',
        'status_id',
        'changed_at',
        'changed_by'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

}
