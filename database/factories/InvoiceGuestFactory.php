<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceGuestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $date =  $this->faker->dateTimeBetween('next Monday', 'next Monday +7 days');
        $ts_issued = $this->faker->dateTimeBetween($date, $date->format('Y-m-d H:i:s').' +2 days');

        return [
            'reservation_id' => $this->faker->randomElement([1,2,3,4,5,6,7,8]),
            'total' => $this->faker->numberBetween(10000, 90000),
            'ts_issued' => $ts_issued,
            "issued_by"  => $this->faker->randomElement([1,2,3,4,5])
        ];
    }
}
