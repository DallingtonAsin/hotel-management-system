<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Event;
use Illuminate\Support\Str;

class EventFactory extends Factory
{
  /**
  * The name of the factory's corresponding model.
  *
  * @var string
  */
  protected $model = Event::class;
  
  /**
  * Define the model's default state.
  *
  * @return array
  */
  public function definition()
  {
    return [
        'title' => $this->faker->text(50),
        'description' => $this->faker->text(150),
        'start_date' => $this->faker->dateTimeThisYear($max = 'now', $timezone = null),
        'end_date' => $this->faker->dateTimeThisYear($max = 'now', $timezone = null),
        'start_time' => $this->faker->time($format = 'H:i', $max = 'now'),
        'event_registra' => $this->faker->firstName,
    ];
  }
}
// vendor/fzaninotto/faker/src/Faker/Provider/Lorem.php 
