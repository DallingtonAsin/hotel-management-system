<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Staff;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Helper;

class StaffFactory extends Factory
{
  /**
  * The name of the factory's corresponding model.
  *
  * @var string
  */
  protected $model = Staff::class;
  
  /**
  * Define the model's default state.
  *
  * @return array
  */
  public function definition()
  {

    $department_id = $this->faker->randomElement([1, 2, 3, 4, 5, 6]);
    $staff_id = Helper::generateStaffId($department_id);
    $default_password = "admin@123";

    return [
      'first_name' => $this->faker->firstName,
      'last_name' => $this->faker->lastName,
      'username' => $this->faker->unique()->lastName,
      'gender' => 'Male',
      'email' => $this->faker->unique()->safeEmail,
      'staff_id' => $staff_id,
      'designation_id' => $this->faker->randomElement([1, 2, 3]),
      'department_id' => $department_id,
      'phone_number' => $this->faker->phoneNumber,
      'other_phone_number' => $this->faker->phoneNumber,
      'address' => $this->faker->state,
      'nin' => strtoupper(Str::random(14)),
      'tin_number'  => $this->faker->numberBetween(1000000, 2000000),
      'nssf_number'  => $this->faker->numberBetween(2000000, 7000000),
      'next_of_kin'  => $this->faker->name,
      'bank_account_number' => $this->faker->numberBetween(10000000000, 20000000000),
      'salary' => $this->faker->numberBetween(500000, 3000000),
      'email_verified_at' => now(),
      'image' => NULL,
      'password' => Hash::make($default_password),
      'remember_token' => Str::random(10),
    ];
  }
}
