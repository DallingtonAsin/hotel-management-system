<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Sale;
use App\Models\Stock;

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

    $item_id = Stock::inRandomOrder()->first()->id;

    return [
        'item_id' => $item_id,
        'quantity' => $this->faker->randomDigitNot(0),
        'original_price' => $this->faker->numberBetween($min = 1000, $max = 7000),
        'selling_price' => $this->faker->numberBetween($min = 4000, $max = 9000),
         'discount' => $this->faker->numberBetween($min = 100, $max = 700),
         'amount' => $this->faker->numberBetween($min = 25400, $max = 45000),
         'paid_amount' => $this->faker->numberBetween($min = 25400, $max = 45000),
         'customer' => $this->faker->lastName,
         'date' => $this->faker->date('Y-m-d H:i:s', 'now'),
         'cashier_id' => $this->faker->randomElement([1,2,3])
    ];
  }
}



