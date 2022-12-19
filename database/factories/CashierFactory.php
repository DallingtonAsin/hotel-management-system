<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\User;
use Illuminate\Support\Str;

class CashierFactory extends Factory
{
  /**
  * The name of the factory's corresponding model.
  *
  * @var string
  */
  protected $model = User::class;
  
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
      'name' => $this->faker->lastName,
      'username'=> $this->faker->firstName,
      'gender' => 'Male',
      'email' => $this->faker->unique()->safeEmail,
      'department_id' => 2,
      'tel_no' => $this->faker->e164phoneNumber,
      'alt_telno' => $this->faker->e164phoneNumber,
      'address' => $this->faker->state,
      'nationalID_no'  => Str::random(12),
      'email_verified_at' => now(),
      'image' => NULL,
      'password' => '$2y$10$A1pLQHR5m8gomliymOCsgeBQKXJdCNDINoHioC3pdlg47ldxwimv2',
      'remember_token' => Str::random(10),
    ];
  }
}


