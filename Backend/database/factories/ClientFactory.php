<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(\App\Client::class, function (Faker $faker) {
    //$status = $faker->numberBetween(0,1);
    return [
        'fname' => $faker->firstName,
        'lname' => $faker->lastName,
        'phone' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        /*'classe_id' => function () {
            return \App\Classe::inRandomOrder()->first()->id;
        },*/
        'active' => 1,
        'activation_token' => Str::random(60),
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});
