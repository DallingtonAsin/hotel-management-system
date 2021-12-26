<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Sale;

$factory->define(Sale::class, function (Faker $faker) {
    return [
        'item' => $faker->text($maxNbChars = 9),
        'item_id' => $faker->text($maxNbChars = 5),
        'quantity' => $faker->randomDigitNot(0),
        'original_price' => $faker->numberBetween($min = 1000, $max = 7000),
        'selling_price' => $faker->numberBetween($min = 4000, $max = 9000),
         'discount' => $faker->numberBetween($min = 100, $max = 700),
         'amount' => $faker->numberBetween($min = 25400, $max = 45000),
         'paid_amount' => $faker->numberBetween($min = 25400, $max = 45000),
         'customer' => $faker->lastName,
         'date' => $faker->date($format='Y-m-d', $max='now'),
         'time' => $faker->time($format = 'H:i:s', $max = 'now'),
         'cashier' => $faker->firstName,
    ];
});
