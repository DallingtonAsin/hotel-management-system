<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator;
use Illuminate\Container\Container;
use App\Models\Reservation;
class ReservationTableSeeder extends Seeder
{

       /**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $startDate =  $this->faker->dateTimeBetween('next Monday', 'next Monday +7 days');
        $endDate = $this->faker->dateTimeBetween($startDate, $startDate->format('Y-m-d H:i:s').' +2 days');

        Reservation::create([
            'guest_id' => $this->faker->randomElement([1,2,3]),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'discount_percent' => $this->faker->numberBetween(1, 10),
            'total_price' => $this->faker->numberBetween($min = 150000, $max = 500000),
            "created_by"  => $this->faker->randomElement([1,2,3,4,5])
        ]);

        Reservation::create([
            'guest_id' => $this->faker->randomElement([1,2,3]),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'discount_percent' => $this->faker->numberBetween(1, 10),
            'total_price' => $this->faker->numberBetween($min = 150000, $max = 500000),
            "created_by"  => $this->faker->randomElement([1,2,3,4,5])
        ]);

        Reservation::create([
            'guest_id' => $this->faker->randomElement([1,2,3]),
            'guest_type_id' => $this->faker->randomElement([1,2,3]),
            'room_id' => $this->faker->randomElement([1,2,3]),
            'arrival_date' => $startDate,
            'departure_date' => $endDate,
            'discount_percent' => $this->faker->numberBetween(1, 10),
            'total_price' => $this->faker->numberBetween($min = 150000, $max = 500000),
            "created_by"  => $this->faker->randomElement([1,2,3,4,5])
        ]);
    }
}
