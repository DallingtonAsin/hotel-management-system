<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Purchase;
use Illuminate\Support\Str;

$factory->define(Purchase::class, function (Faker $faker) {
    return [
        'item_id' => Str::random(3),
        'item' => Str::random(7),
        'quantity' => $faker->randomDigitNot(0),
        'cost_price_per_item' => $faker->numberBetween($min=4000, $max=6000),
        'supplier' => $faker->lastName,
        'recorded_by' => $faker->firstName,
    ];
});
