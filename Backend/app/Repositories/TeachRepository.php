<?php


namespace App\Repositories;


use App\Teach;

/**
 * Class TeachRepository
 * @package App\Repositories
 */
class TeachRepository extends CrudRepository
{
    /**
     * AdminRepository constructor.
     * @param Teach $teach
     */
    public function __construct(Teach $teach)
    {
        parent::__construct($teach);
    }
}
