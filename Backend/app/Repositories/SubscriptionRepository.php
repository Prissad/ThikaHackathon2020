<?php

namespace App\Repositories;

use App\Subscription;

/**
 * Class SubscriptionRepository
 * @package App\Repositories
 */
class SubscriptionRepository extends CrudRepository
{
    /**
     * SubscriptionRepository constructor.
     * @param Subscription $subscription
     */
    public function __construct(Subscription $subscription)
    {
        parent::__construct($subscription);
    }
}
