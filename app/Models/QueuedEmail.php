<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QueuedEmail extends Model
{
    protected $table = 'queued_emails';
    protected $fillable = ['received_data', 'description', 'run', 'email'];
    protected $casts = ['run' => "boolean"];
}
