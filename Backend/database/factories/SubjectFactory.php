<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Subject;
use Faker\Generator as Faker;

$factory->define(Subject::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'classe_id' =>  function () {
            return \App\Classe::inRandomOrder()->first()->id;
        },
    ];
});
