<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Event;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence($nbWords = 4, $variableNbWords = true),
        'description' => $faker->text($maxNbChars = 150),
        'start_date' => $faker->dateTimeThisYear($max = 'now', $timezone = null),
        'end_date' => $faker->dateTimeThisYear($max = 'now', $timezone = null),
        'start_time' => $faker->time($format = 'H:i', $max = 'now'),
        'event_registra' => $faker->firstName,
    ];
});
