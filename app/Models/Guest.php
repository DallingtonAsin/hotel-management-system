<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $table = 'guests';
    public $timestamps = true;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'job_title',
        'tin_number',
        'company_name',
        'company_contact',
        'company_email',
        'company_tin',
        'nationality',
        'passport_number',
        'nin',
        'card_issue_date',
        'card_expiry_date',
        'created_by'
    ];

}