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
        'company_name',
        'tin_number',
        'company_contact',
        'company_email',
        'phone_number',
        'email',
        'passport_number',
        'tax_number',
        'nin',
        'other_details',
        'created_by'
    ];

}