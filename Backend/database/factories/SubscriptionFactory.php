<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Subscription;
use Faker\Generator as Faker;

$factory->define(Subscription::class, function (Faker $faker) {
    /*$subscriptions=["Free","Silver","Gold"];
    $status = $faker->numberBetween(0,2);
    return [
        'type' => $subscriptions[$status]
    ];*/
});
