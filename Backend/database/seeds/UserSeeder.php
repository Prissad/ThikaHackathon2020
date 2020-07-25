<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Client::class, 200)->create()->each(function ($client) {
            $client->clientDetails()->save(factory(\App\ClientDetails::class)->make());
        });
        factory(\App\Admin::class, 1)->create();
        factory(\App\Teacher::class, 5)->create();/*->each(function ($teacher) {

            $teaches = \App\Teach::inRandomOrder()->limit(rand(1, 3))->get();
            foreach ($teaches as $teach) {
                $teacher->teaches()->attach($teach->id);
            }
        });*/
    }
}
