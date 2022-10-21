<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SMS extends Model
{
    protected $table = "queued_sms";
    protected $fillable = [
        'sender_telno',
        'receiver_telno',
        'message',
        'queued',
        'sent',
    ];
}
