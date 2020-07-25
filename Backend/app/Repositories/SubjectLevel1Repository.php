<?php

namespace App\Repositories;

use App\SubjectLevel1;

/**
 * Class SubjectLevel1Repository
 * @package App\Repositories
 */
class SubjectLevel1Repository extends CrudRepository
{
    /**
     * SubjectLevel1Repository constructor.
     * @param SubjectLevel1 $subjectLevel1
     */
    public function __construct(SubjectLevel1 $subjectLevel1)
    {
        parent::__construct($subjectLevel1);
    }
}
