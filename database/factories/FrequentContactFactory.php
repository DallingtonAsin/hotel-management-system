<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FrequentContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'email' => $this->faker->unique()->safeEmail,
            'phone_number' => $this->faker->phoneNumber,
            'tin' => 'TN'. $this->faker->numberBetween(10000, 70000),
            'contact_person' => $this->faker->name,
            'price' => $this->faker->numberBetween(10000, 70000),
            'currency_code' => $this->faker->randomElement(['UGX', 'KES', 'TZS']),
            "created_by"  => $this->faker->randomElement([1,2,3,4,5])
          ];
    }
}
