<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $table = 'salaries';
	public $timestamps = true;
	protected $fillable = [
		'employee_id',
		'amount',
		'pay_date',
		'created_by'
	];
}
