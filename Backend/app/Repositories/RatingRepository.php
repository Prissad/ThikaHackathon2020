<?php

namespace App\Repositories;

use App\Rating;

/**
 * Class RatingRepository
 * @package App\Repositories
 */
class RatingRepository extends CrudRepository
{
    /**
     * RatingRepository constructor.
     * @param Rating $rating
     */
    public function __construct(Rating $rating)
    {
        parent::__construct($rating);
    }
}
