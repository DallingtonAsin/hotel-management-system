<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Sale;
use Illuminate\Support\Str;

class SaleFactory extends Factory
{
  /**
  * The name of the factory's corresponding model.
  *
  * @var string
  */
  protected $model = Sale::class;
  
  /**
  * Define the model's default state.
  *
  * @return array
  */
  public function definition()
  {
    return [
        'item' => $this->faker->text($maxNbChars = 9),
        'item_code' => $this->faker->text($maxNbChars = 5),
        'quantity' => $this->faker->randomDigitNot(0),
        'original_price' => $this->faker->numberBetween($min = 1000, $max = 7000),
        'selling_price' => $this->faker->numberBetween($min = 4000, $max = 9000),
         'discount' => $this->faker->numberBetween($min = 100, $max = 700),
         'amount' => $this->faker->numberBetween($min = 25400, $max = 45000),
         'paid_amount' => $this->faker->numberBetween($min = 25400, $max = 45000),
         'customer' => $this->faker->lastName,
         'date' => $this->faker->date($format='Y-m-d', $max='now'),
         'time' => $this->faker->time($format = 'H:i:s', $max = 'now'),
         'cashier' => $this->faker->firstName,
         'workedon_by' => $this->faker->firstName,
    ];
  }
}



