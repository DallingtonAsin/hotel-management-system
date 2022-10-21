<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Damage;
use Illuminate\Support\Str;

class DamageFactory extends Factory
{
  /**
  * The name of the factory's corresponding model.
  *
  * @var string
  */
  protected $model = Damage::class;
  
  /**
  * Define the model's default state.
  *
  * @return array
  */
  public function definition()
  {
    return [
      'item_id' => Str::random(3),
      'item' => Str::random(7),
      'category' => Str::random(6),
      'quantity' => $this->faker->randomDigit,
      'buying_price' => $this->faker->numberBetween($min=1000, $max=9000),
    ];
  }
}
