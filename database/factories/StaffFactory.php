<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Staff;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

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
    return [
      'first_name' => $this->faker->firstName,
      'last_name' => $this->faker->lastName,
      'username' => $this->faker->unique()->lastName,
      'gender' => 'Male',
      'email' => $this->faker->unique()->safeEmail,
      'staff_id' => 'SID_'.''.$this->faker->numberBetween(100, 700),
      'designation_id' => $this->faker->randomElement([1, 2, 3]),
      'department_id' => $this->faker->randomElement([1, 2]),
      'phone_number' => $this->faker->phoneNumber,
      'other_phone_number' => $this->faker->phoneNumber,
      'address' => $this->faker->state,
      'nin' => strtoupper(Str::random(14)),
      'tin_number'  => $this->faker->numberBetween(1000000, 2000000),
      'nssf_number'  => $this->faker->numberBetween(2000000, 7000000),
      'next_of_kin'  => $this->faker->name,
      'email_verified_at' => now(),
      'image' => NULL,
      'password' => Hash::make('12345678'),
      'remember_token' => Str::random(10),
    ];
  }
}
