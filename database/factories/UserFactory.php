<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
    'first_name' => $faker->firstName,
    'last_name' => $faker->lastName,
    'name' => $faker->name,
    'username' => $faker->unique()->lastName,
    'gender' => 'Male',
    'email' => $faker->unique()->safeEmail,
    'user_role' => $faker->randomElement([1, 2]),
    'tel_no' => $faker->e164phoneNumber,
    'alt_telno' => $faker->e164phoneNumber,
    'address' => $faker->state,
    'nationalID_no' => strtoupper(Str::random(14)),
    'email_verified_at' => now(),
    'image' => NULL,
    'password' => Hash::make('12345678'),
    'remember_token' => Str::random(10),
  ];
});
