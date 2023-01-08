<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Guest;

class GuestFactory extends Factory
{

         /**
  * The name of the factory's corresponding model.
  *
  * @var string
  */
  protected $model = Guest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'phone_number' => $this->faker->phoneNumber,
            "created_by"  => $this->faker->randomElement([1,2,3,4,5])
        ];
    }
}
