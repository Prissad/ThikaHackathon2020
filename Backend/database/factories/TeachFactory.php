<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Teach;
use Faker\Generator as Faker;

$factory->define(Teach::class, function (Faker $faker) {
    return [
        'subject_id' => function () {
            return \App\Subject::inRandomOrder()->first()->id;
        },
        'teacher_id' => function () {
            return \App\Teacher::inRandomOrder()->first()->id;
        },
        'classe_id' => function () {
            return \App\Classe::inRandomOrder()->first()->id;
        }

    ];
});
