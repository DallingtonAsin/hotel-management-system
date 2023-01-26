<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Damage;
use App\Models\Stock;
use App\Models\Staff;
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

    $item = Stock::inRandomOrder()->first();
    $recorded_by = Staff::inRandomOrder()->first()->id;


    return [
      'item_id' => $item->id,
      'quantity' => $this->faker->randomDigit,
      'recorded_by' => $recorded_by
    ];
  }
}
