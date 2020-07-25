<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'text' => $faker->text,
        'user_id' =>  function () {
            return \App\User::inRandomOrder()->first()->id;
        },
        'video_id' =>  function () {
            return \App\Video::inRandomOrder()->first()->id;
        },
    ];
});
