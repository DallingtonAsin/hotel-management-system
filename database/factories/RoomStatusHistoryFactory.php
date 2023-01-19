<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class RoomStatusHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
     
        return [
            'room_id' => $this->faker->randomElement([1,2,3,4,5]),
            'status_id' => $this->faker->randomElement([1,2,3,4]),
            'changed_at' => Carbon::now(),
            'changed_by' => $this->faker->randomElement([1,2,3,4])
          ];
    }
}
