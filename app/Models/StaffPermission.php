<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffPermission extends Model
{
    use HasFactory;

    protected $table = 'staff_permissions';
    public $timestamps = true;

	protected $fillable = [
		'permission_id',
		'staff_id',
	];

}
