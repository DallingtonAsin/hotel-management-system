<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;

    protected $table = 'expenses';
    public $timestamps = true;

    protected $fillable = [
        'type_id',
        'amount',
        'date_of_expenditure',
        'is_deleted',
        'recorded_by',
    ];
}
