<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\StockCat;
use Illuminate\Support\Str;
use App\Models\Staff;

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
        'name' => Str::random(8),
        'created_by' => Staff::inRandomOrder()->first()->id
    ];
  }
}
