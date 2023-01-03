<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guest;
use Faker\Generator;
use Illuminate\Container\Container;
class GuestTableSeeder extends Seeder
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
        Guest::create([
            'first_name' => 'Olivia',
            'last_name' => 'Birungi',
            'guest_type_id' => $this->faker->randomElement([1,2,3]),
            'email' => $this->faker->email,
            'phone_number' => '0700477421',
            'address' => 'Nakawa, Kampala'
        ]);

        Guest::create([
            'first_name' => 'Dallington',
            'last_name' => 'Asingwire',
            'guest_type_id' => $this->faker->randomElement([1,2,3]),
            'email' => $this->faker->email,
            'phone_number' => '0774014727',
            'address' => 'Ntinda, Kampala'
        ]);

        Guest::create([
            'first_name' => 'Francis',
            'last_name' => 'Agaba',
            'guest_type_id' => $this->faker->randomElement([1,2,3]),
            'email' => $this->faker->email,
            'phone_number' => '0786857180',
            'address' => 'Kyanja, Kampala'
        ]);
    }
}
