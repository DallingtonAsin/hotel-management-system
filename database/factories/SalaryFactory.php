<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Salary;

class SalaryFactory extends Factory
{

      /**
  * The name of the factory's corresponding model.
  *
  * @var string
  */
  protected $model = Salary::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8]),
            'amount' => $this->faker->numberBetween(50000, 100000),
            'pay_date' => $this->faker->dateTimeBetween('next Monday', 'next Monday +7 days')
          ];
    }
}
