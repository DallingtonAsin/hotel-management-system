<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Customer;

$factory->define(Customer::class, function (Faker $faker) {
    return [
      'name' => $faker->name,
      'contact' => $faker->unique()->e164phoneNumber,
      'item_taken' => $faker->randomElement([1,2,3,4]),
      'debt' => $faker->numberBetween($min=1000, $max=5000),
      'credit' => $faker->numberBetween($min=5000, $max=9500),
      'added_by' => $faker->firstName,

    ];
});
