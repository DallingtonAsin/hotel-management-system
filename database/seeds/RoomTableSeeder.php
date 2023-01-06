<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Container\Container;
use Faker\Generator;
use App\Models\Room;

class RoomTableSeeder extends Seeder
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
        Room::create([
            'type_id' => $this->faker->randomElement([1,2,3,4,5,6,7]),
            'number' => $this->faker->randomElement(['A', 'B', 'C','D', 'E']).''.$this->faker->numberBetween(500, 700),
            'floor_number' => $this->faker->randomElement([1,2,3,4, 5, 6, 7]),
            'description' => 'Double room with 5x6 nice bed',
            'status' => $this->faker->randomElement(['Occupied', 'Vacant']),
            "created_by"  => $this->faker->randomElement([1,2,3,4,5]),
        ]);

        Room::create([
            'type_id' => $this->faker->randomElement([1,2,3,4]),
            'number' => $this->faker->randomElement(['A', 'B', 'C','D', 'E']).''.$this->faker->numberBetween(700, 800),
            'floor_number' => $this->faker->randomElement([1,2,3,4, 5, 6]),
            'description' => 'Single room with 6x6 nice bed',
            'status' => $this->faker->randomElement(['Occupied', 'Vacant']),
            "created_by"  => $this->faker->randomElement([1,2,3,4,5]),
        ]);
        // php artisan db:seed --class=RoomsTableSeeder

        Room::create([
            'type_id' => $this->faker->randomElement([1,2,3,4]),
            'number' => $this->faker->randomElement(['A', 'B', 'C','D', 'E']).''.$this->faker->numberBetween(100, 400),
            'floor_number' => $this->faker->randomElement([1,2,3,4, 5]),
            'description' => 'Single room with good facilities',
            'status' => $this->faker->randomElement(['Occupied', 'Vacant']),
            "created_by"  => $this->faker->randomElement([1,2,3,4,5]),
        ]);

        Room::create([
            'type_id' => $this->faker->randomElement([1,2,3,4]),
            'number' => $this->faker->randomElement(['A', 'B', 'C','D', 'E']).''.$this->faker->numberBetween(400, 600),
            'floor_number' => $this->faker->randomElement([1,2,3,4, 5, 6, 7]),
            'description' => 'Single room with 6x6 nice bed',
            'status' => $this->faker->randomElement(['Occupied', 'Vacant']),
            "created_by"  => $this->faker->randomElement([1,2,3,4,5]),
        ]);

        Room::create([
            'type_id' => $this->faker->randomElement([1,2,3,4]),
            'number' => $this->faker->randomElement(['A', 'B', 'C','D', 'E']).''.$this->faker->numberBetween(100, 250),
            'floor_number' => $this->faker->randomElement([1,2,3,4, 5]),
            'description' => 'Single room with 6x6 nice bed',
            'status' => $this->faker->randomElement(['Occupied', 'Vacant']),
            "created_by"  => $this->faker->randomElement([1,2,3,4,5]),
        ]);

   
    }
}