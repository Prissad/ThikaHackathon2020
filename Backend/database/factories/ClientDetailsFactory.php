<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

//$factory->define(Model::class, function (Faker $faker) {
$factory->define(\App\ClientDetails::class, function (Faker $faker) {
    $subscription_free_id = \App\Subscription::where([
        'name' => 'Free'])->first()->id;
    $subscription_silver_id = \App\Subscription::where([
        'name' => 'Silver'])->first()->id;
    /*$subscription_gold_id = \App\Subscription::where([
        'name' => 'Gold'])->first()->id;*/
    $status = $faker->numberBetween(1,3);
    return [
        'grade' => $faker->boolean,
        'birthday' => $faker->date(),
        'establishment' => $faker->address,
        'region' => $faker->city,
        'subscription_id' => $status == 1 ? $subscription_silver_id : $subscription_free_id ,

        'classe_id' => function () {
            return \App\Classe::inRandomOrder()->first()->id;
        },

    ];
});
