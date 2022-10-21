<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\StockCat;
use Illuminate\Support\Str;

$factory->define(StockCat::class, function (Faker $faker) {
    return [
        'item_category' => Str::random(8)
    ];
});
