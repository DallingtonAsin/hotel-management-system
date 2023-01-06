<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoomType;
use Faker\Generator;
use Illuminate\Container\Container;

class RoomTypeTableSeeder extends Seeder
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

        RoomType::create([
            "name" => "Executive Suite",
            "single_occupancy_rate" => 3000,
            "double_occupancy_rate" => 5000,
            "created_by"  => $this->faker->randomElement([1,2,3,4,5]),
        ]);

        RoomType::create([
            "name" => "Deluxe Suite",
            "single_occupancy_rate" => 2500,
            "double_occupancy_rate" => 4000,
            "created_by"  => $this->faker->randomElement([1,2,3,4,5]),
        ]);

        RoomType::create([
            "name" => "Standard Suite",
            "single_occupancy_rate" => 1000,
            "double_occupancy_rate" => 1500,
            "created_by"  => $this->faker->randomElement([1,2,3,4,5]),
        ]);

        RoomType::create([
            "name" => "Executive Room",
            "single_occupancy_rate" => 80,
            "double_occupancy_rate" => 100,
            "created_by"  => $this->faker->randomElement([1,2,3,4,5]),
        ]);

        RoomType::create([
            "name" => "Deluxe Room",
            "single_occupancy_rate" => 70,
            "double_occupancy_rate" => 90,
            "created_by"  => $this->faker->randomElement([1,2,3,4,5]),
        ]);

        RoomType::create([
            "name" => "Deluxe Double",
            "single_occupancy_rate" => 60,
            "double_occupancy_rate" => 80,
            "created_by"  => $this->faker->randomElement([1,2,3,4,5]),
        ]);

        RoomType::create([
            "name" => "Standard Room",
            "single_occupancy_rate" => 50,
            "double_occupancy_rate" => 70,
            "created_by"  => $this->faker->randomElement([1,2,3,4,5]),
        ]);
    }
}
