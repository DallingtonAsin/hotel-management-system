<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Payment;

class PaymentFactory extends Factory
{

     /**
  * The name of the factory's corresponding model.
  *
  * @var string
  */
  protected $model = Payment::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'guest_id' => $this->faker->randomElement([1, 2]),
            'invoice_id' => $this->faker->randomElement([1, 2, 3, 4, 5, 6]),
            'amount' => $this->faker->numberBetween(50000, 90000),
            'method' => $this->faker->randomElement(['cash', 'credit card']),
            'date' => $this->faker->dateTimeBetween('next Monday', 'next Monday +7 days'),
            "created_by"  => $this->faker->randomElement([1,2,3,4,5])
          ];
    }
}
