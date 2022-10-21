<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Expense;
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
    return [
      'expense_type' =>$this->faker->text($maxNbChars = 6),
      'amount' => $this->faker->numberBetween($min=9000, $max=15000) ,
      'date_of_expenditure' =>$this->faker->date($format = 'Y-m-d', $max = 'now')
    ];
  }
}

