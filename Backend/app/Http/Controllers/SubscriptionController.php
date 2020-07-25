<?php

namespace App\Http\Controllers;

use App\Repositories\SubscriptionRepository;

class SubscriptionController extends CrudController
{

    /**
     * SubscriptionController constructor.
     * @param SubscriptionRepository $subscriptionRepository
     */

    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $relations = [];
        $orderBy = [];
        $conditions = [];
        $nullConditions = [];
        $whereInConditions = [];
        $selectedAttributes = ['*'];
        parent::__construct($subscriptionRepository, $relations, $orderBy, $conditions, $nullConditions, $whereInConditions, $selectedAttributes);
    }
}
