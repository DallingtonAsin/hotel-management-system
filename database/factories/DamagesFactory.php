<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Damage;
use Illuminate\Support\Str;

$factory->define(Damage::class, function (Faker $faker) {
    return [
      'item_id' => Str::random(3),
      'item' => Str::random(7),
      'category' => Str::random(6),
      'quantity' => $faker->randomDigitNot(0),
      'buying_price' => $faker->numberBetween($min=1000, $max=9000),
    ];
});
