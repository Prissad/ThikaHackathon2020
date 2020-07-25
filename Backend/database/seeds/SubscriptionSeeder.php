<?php

use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subscriptions=["Free","Silver","Gold"];
        foreach ($subscriptions as $subscription) {
            \App\Subscription::updateOrCreate(['name' => $subscription ], ['name' => $subscription]);
        }
    }
}
