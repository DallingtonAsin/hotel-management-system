<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Designation;
use Faker\Generator;
use Illuminate\Container\Container;
class DesignationTableSeeder extends Seeder
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
        Designation::create([
            "name" => "Manager",
            "department_id" => $this->faker->randomElement([1,2,3,4,5,6]),
            "created_by" => "Olivia",
        ]);

        Designation::create([
            "name" => "Office Assistant",
            "department_id" => $this->faker->randomElement([1,2,3,4,5,6]),
            "created_by" => "Olivia",
        ]);

        Designation::create([
            "name" => "Cashier",
            "department_id" => $this->faker->randomElement([1,2,3,4,5,6]),
            "created_by" => "Olivia",
        ]);

        Designation::create([
            "name" => "House Keeper",
            "department_id" => $this->faker->randomElement([1,2,3,4,5,6]),
            "created_by" => "Olivia",
        ]);

        Designation::create([
            "name" => "Receiptionist",
            "department_id" => $this->faker->randomElement([1,2,3,4,5,6]),
            "created_by" => "Olivia",
        ]);

        Designation::create([
            "name" => "Computer Assistant",
            "department_id" => $this->faker->randomElement([1,2,3,4,5,6]),
            "created_by" => "Olivia",
        ]);
    }
}
