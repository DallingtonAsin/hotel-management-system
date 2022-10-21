<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\StockCat;
use Illuminate\Support\Str;

class StockCatFactory extends Factory
{
  /**
  * The name of the factory's corresponding model.
  *
  * @var string
  */
  protected $model = StockCat::class;
  
  /**
  * Define the model's default state.
  *
  * @return array
  */
  public function definition()
  {
    return [
        'item_category' => Str::random(8)
    ];
  }
}
