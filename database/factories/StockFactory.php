<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Stock;
use Illuminate\Support\Str;

$factory->define(Stock::class, function (Faker $faker) {
    return [
      'item_code' => Str::random(3),
      'item' => Str::random(7),
      'category' => Str::random(6),
      'quantity' => $faker->randomDigitNot(0),
      'threshold_qty' => $faker->randomDigitNot(0),
      'buying_price' => $faker->numberBetween($min=4000, $max=6000),
      'selling_price' => $faker->numberBetween($min=6000, $max=9000),
      'supplier' => $faker->lastName,
      'date_of_entry' => $faker->dateTimeThisYear($max = 'now', $timezone = null),
      'expiry_date' => $faker->dateTimeThisYear($max = 'now', $timezone = null),
    ];
});
