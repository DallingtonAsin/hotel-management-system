<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Permission;


class Staff extends Authenticatable
{
  use Notifiable;
  use HasFactory;

  protected $table = 'staff';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'first_name',
    'last_name',
    'username',
    'gender',
    'email',
    'department_id',
    'phone_number',
    'other_phone_number',
    'address',
    'nin',
    'tin_number',
    'nssf_number',
    'next_of_kin',
    'bank_account_number',
    'salary',
    'type',
    'status',
    'is_active',
    'password',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function permissions()
  {
    return $this->belongsToMany(Permission::class, 'staff_permissions');
  }

  public function hasPermission($permissionName)
  {

    return $this->permissions()->wherePivot('permission_id', function ($query)
    use ($permissionName) {
      $query->select('id')->from('permissions')->where('name', $permissionName);
    })->wherePivot('active', true)->exists();
    
  }

  public function syncPermissions(array $permissions)
  {
      $this->permissions()->sync($permissions);
      return $this->permissions()->updateExistingPivot($permissions, ['active' => 1]);
  }

}
