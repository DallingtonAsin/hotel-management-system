<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Reservation;

class ReservationFactory extends Factory
{

       /**
  * The name of the factory's corresponding model.
  *
  * @var string
  */
  protected $model = Reservation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $startDate =  $this->faker->dateTimeBetween('next Monday', 'next Monday +7 days');
        $endDate = $this->faker->dateTimeBetween($startDate, $startDate->format('Y-m-d H:i:s').' +2 days');

        return [
            'arrival_date' => $startDate,
            'departure_date' => $endDate,
            'room_id' => $this->faker->randomElement([1,2,3]),
            'guest_id' => $this->faker->randomElement([1,2,3,4,5,6,7,8]),
            'guest_type_id' => $this->faker->randomElement([1,2,3]),
            'occupancy_type' => $this->faker->randomElement(['single', 'double']),
            "created_by"  => $this->faker->randomElement([1,2,3,4,5])
          ];
    }
}
