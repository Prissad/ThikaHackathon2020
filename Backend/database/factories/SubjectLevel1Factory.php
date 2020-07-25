<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SubjectLevel1;
use Faker\Generator as Faker;

$factory->define(SubjectLevel1::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'pdf' => $faker->sentence . $faker->fileExtension,
        'subject_id' => \App\Subject::inRandomOrder()->value('id'),

    ];
});
