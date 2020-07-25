<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Video;
use Faker\Generator as Faker;

$factory->define(Video::class, function (Faker $faker) {
    $status = $faker->numberBetween(1,5);
    $status4 = $faker->numberBetween(1,5);
    $status1 = $faker->numberBetween(1,3);
    $status2 = $faker->numberBetween(1,3);
    return [
        'title' => $faker->title,
        'type' => $faker->mimeType,
        'url' => $faker->url,
        'payed' => $status !==2 ? false: true,
        'description' => $status4 !==2 ? null: 'une petite description pour la video',

        'user_id' =>  function () {
            return \App\User::inRandomOrder()->first()->id;
        },
        'classe_id' =>  function () {
            return \App\Classe::inRandomOrder()->first()->id;
        },


    ];
});
