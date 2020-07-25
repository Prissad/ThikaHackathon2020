<?php

namespace App\Repositories;

use App\Subject;

/**
 * Class SubjectRepository
 * @package App\Repositories
 */
class SubjectRepository extends CrudRepository
{
    /**
     * SubjectRepository constructor.
     * @param Subject $subject
     */
    public function __construct(Subject $subject)
    {
        parent::__construct($subject);
    }
}
