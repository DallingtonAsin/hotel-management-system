<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrequentContact extends Model
{
    use HasFactory;

    protected $table = 'frequent_contacts';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'tin',
        'contact_person',
        'price',
        'currency_code',
        'created_by'
    ];
}
