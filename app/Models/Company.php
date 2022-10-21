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
        'company_name',
        'company_abbrev',
        'company_email',
        'company_address',
        'company_motto',
        'company_logo'    
    ];

        
}
