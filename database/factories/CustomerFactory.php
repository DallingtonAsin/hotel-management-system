<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;

class CustomerFactory extends Factory
{
  /**
  * The name of the factory's corresponding model.
  *
  * @var string
  */
  protected $model = Customer::class;
  
  /**
  * Define the model's default state.
  *
  * @return array
  */
  public function definition()
  {
    return [
      'name' => $this->faker->name,
      'contact' => $this->faker->unique()->phoneNumber,
      'item_taken' => $this->faker->randomElement([1,2,3,4]),
      'debt' => $this->faker->numberBetween($min=1000, $max=5000),
      'credit' => $this->faker->numberBetween($min=5000, $max=9500),
      'created_by' => $this->faker->firstName,
    ];
  }
}
