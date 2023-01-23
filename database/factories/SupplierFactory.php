<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Supplier;
use App\Staff;

class SupplierFactory extends Factory
{
  /**
  * The name of the factory's corresponding model.
  *
  * @var string
  */
  protected $model = Supplier::class;
  
  /**
  * Define the model's default state.
  *
  * @return array
  */
  public function definition()
  {
    $recorded_by = Staff::inRandomOrder()->first()->id;
    return [
      'name' => $this->faker->firstName,
      'tin' => $this->faker->numberBetween(1000000, 9000000),
      'phone_number' => $this->faker->e164phoneNumber,
      'email' => $this->faker->unique()->safeEmail,
      'address' => $this->faker->state,
      'debt' => $this->faker->numberBetween($min = 1000, $max = 9000),
      'credit' => $this->faker->numberBetween($min = 9000, $max = 10000),
      'created_by' => $recorded_by
    ];
  }
}
