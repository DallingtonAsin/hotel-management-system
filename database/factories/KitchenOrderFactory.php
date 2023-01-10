<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KitchenOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'order_number' => $this->faker->unique()->numberBetween(1, 10000),
            'table_number' => $this->faker->numberBetween(1, 10),
            "status"  => $this->faker->randomElement(['In Progress', 'Completed', 'Cancelled']),
            'order_date' => $this->faker->dateTimeBetween('next Monday', 'next Monday +7 days'),
            "created_by"  => $this->faker->randomElement([1,2,3,4,5]),

        ];
    }
}
