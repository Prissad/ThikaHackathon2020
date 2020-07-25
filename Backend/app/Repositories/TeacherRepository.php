<?php

namespace App\Repositories;

use App\Teacher;

/**
 * Class TeacherRepository
 * @package App\Repositories
 */
class TeacherRepository extends CrudRepository
{
    /**
     * TeacherRepository constructor.
     * @param Teacher $teacher
     */
    public function __construct(Teacher $teacher)
    {
        parent::__construct($teacher);
    }
}
