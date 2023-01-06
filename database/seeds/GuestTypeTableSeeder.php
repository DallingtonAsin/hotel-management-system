<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GuestType;
use Faker\Generator;
use Illuminate\Container\Container;

class GuestTypeTableSeeder extends Seeder
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
        GuestType::create([
            "name" => "Regular",
            "is_regular" => true,
            "is_corporate" => false,
            "created_by"  => $this->faker->randomElement([1,2,3,4,5])
        ]);

        GuestType::create([
            "name" => "Walkin",
            "is_regular" => true,
            "is_corporate" => false,
            "created_by"  => $this->faker->randomElement([1,2,3,4,5])
        ]);

        GuestType::create([
            "name" => "Corporate",
            "is_regular" => false,
            "is_corporate" => true,
            "created_by"  => $this->faker->randomElement([1,2,3,4,5])
        ]);
    }
}
