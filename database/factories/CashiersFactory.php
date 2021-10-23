<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\User;

$factory->define(User::class, function (Faker $faker) {
    return [
      'first_name' => $faker->firstName,
      'last_name' => $faker->lastName,
      'name' => $faker->lastName,
      'username'=> $faker->firstName,
      'gender' => 'Male',
      'email' => $faker->unique()->safeEmail,
      'user_role' => 2,
      'tel_no' => $faker->e164phoneNumber,
      'alt_telno' => $faker->e164phoneNumber,
      'address' => $faker->state,
      'nationalID_no'  => Str::random(12),
      'email_verified_at' => now(),
      'image' => NULL,
      'password' => '$2y$10$A1pLQHR5m8gomliymOCsgeBQKXJdCNDINoHioC3pdlg47ldxwimv2',
      'remember_token' => Str::random(10),

    ];
});
