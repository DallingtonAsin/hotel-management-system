<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestType extends Model
{
    protected $table = 'guest_types';
    public $timestamps = true;
    protected $fillable = [
      'id',
      'name',
      'added_by',
    ];
}
