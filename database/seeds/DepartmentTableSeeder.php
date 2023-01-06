<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use Faker\Generator;
use Illuminate\Container\Container;
class DepartmentTableSeeder extends Seeder
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
       
        Department::create([
            "name" => "Restaurant and Bar",
            "created_by"  => $this->faker->randomElement([1,2,3,4,5]),
        ]);

        Department::create([
            "name" => "Human Resource",
            "created_by"  => $this->faker->randomElement([1,2,3,4,5]),
        ]);

        Department::create([
            "name" => "Store",
            "created_by"  => $this->faker->randomElement([1,2,3,4,5]),
        ]);

        Department::create([
            "name" => "House Keeping",
            "created_by"  => $this->faker->randomElement([1,2,3,4,5]),
        ]);

        Department::create([
            "name" => "Accomodation",
            "created_by"  => $this->faker->randomElement([1,2,3,4,5]),
        ]);

        Department::create([
            "name" => "Finance & Accounting",
            "created_by"  => $this->faker->randomElement([1,2,3,4,5]),
        ]);
    }
}
