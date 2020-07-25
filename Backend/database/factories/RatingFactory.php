<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Rating;
use Faker\Generator as Faker;

$factory->define(Rating::class, function (Faker $faker) {
//    $number = $faker->numberBetween(0,2);
    return [
        /*'rating' => $number ,
        'description' => $faker->text(50),
        'user_id' =>  function () {
            return \App\User::inRandomOrder()->first()->id;
        },
        'video_id' =>  function () {
            return \App\Video::inRandomOrder()->first()->id;
        },*/

    ];
});
