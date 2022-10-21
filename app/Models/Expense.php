<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'expenses';
    public $timestamps = false;
    protected $fillable = [
        'expense_type',
        'amount',
        'date_of_expenditure'
    ];
}
