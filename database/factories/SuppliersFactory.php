<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Supplier;

$factory->define(Supplier::class, function (Faker $faker) {
    return [
      'name' => $faker->firstName,
      'address' => $faker->state,
      'contact' => $faker->e164phoneNumber,
      'email' => $faker->unique()->safeEmail,
      'debt' => $faker->numberBetween($min = 1000, $max = 9000),
      'credit' => $faker->numberBetween($min = 9000, $max = 10000),
    ];
});
