<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
	protected $table = 'customers';
	// public $timestamps = false;
	// protected $dateFormat = 'U';
	// const CREATED_AT = 'creattion_date';
	// const UPDATED_AT = 'last_update';
	// protected $connection ='connection-name';

    protected $fillable = [
        'name',
         'contact',
         'debt',
         'credit',      
    ];

public $timestamps = true;

}
