<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

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
