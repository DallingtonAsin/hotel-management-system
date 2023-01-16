<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Staff;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'permissions';
    public $timestamps = true;

	protected $fillable = [
		'name',
	];

    public function staff()
    {
        return $this->belongsToMany(Staff::class, 'staff_permissions');
    }

}
