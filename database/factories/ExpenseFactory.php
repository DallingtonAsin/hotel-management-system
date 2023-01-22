<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Expense;
use App\Models\ExpenseType;
use App\Staff;
use Illuminate\Support\Str;

class ExpenseFactory extends Factory
{
  /**
  * The name of the factory's corresponding model.
  *
  * @var string
  */
  protected $model = Expense::class;
  
  /**
  * Define the model's default state.
  *
  * @return array
  */
  public function definition()
  {

    $type_id = ExpenseType::inRandomOrder()->first()->id;
    $recorded_by = Staff::inRandomOrder()->first()->id;
 
    return [
      'type_id' => $type_id,
      'amount' => $this->faker->numberBetween($min=9000, $max=15000) ,
      'date_of_expenditure' =>$this->faker->date($format = 'Y-m-d', $max = 'now'),
      'recorded_by' => $recorded_by
    ];
  }
}

