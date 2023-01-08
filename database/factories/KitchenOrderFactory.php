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
            'item' => $this->faker->randomElement(['Beef', 'Chicken', 'Goat Meat', 'G.nuts', 'Fish']),
            "quantity"  => $this->faker->numberBetween(1, 15),
            "status"  => $this->faker->randomElement(['In Progress', 'Completed', 'Cancelled']),
            "created_by"  => $this->faker->randomElement([1,2,3,4,5]),

        ];
    }
}
