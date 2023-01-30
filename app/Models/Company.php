<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;
    protected $table = 'company_details';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'street',
        'city',
        'state',
        'zip',
        'phone_number',
        'email',
        'website_url',
        'category',
        'services',
        'logo',
        'is_registered'  
    ];

        
}
