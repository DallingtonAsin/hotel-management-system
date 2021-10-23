<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Expense;

$factory->define(Expense::class, function (Faker $faker) {
    return [
      'expense_type' =>$faker->text($maxNbChars = 6),
      'amount' => $faker->numberBetween($min=9000, $max=15000) ,
      'date_of_expenditure' =>$faker->date($format = 'Y-m-d', $max = 'now')
    ];
});
