<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\FilePDF;
use Faker\Generator as Faker;

$factory->define(FilePDF::class, function (Faker $faker) {
    $status = $faker->numberBetween(1,3);
    return [
        'title' => $faker->name,
        'pdf' => $faker->sentence . $faker->fileExtension,
        'classe_id' => $status !== 1 ? function () {
            return \App\Classe::inRandomOrder()->first()->id;
        } : null,
        'type' => $status !==2 ? $faker->name: null,
    ];
});
