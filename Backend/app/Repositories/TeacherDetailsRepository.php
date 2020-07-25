<?php

namespace App\Repositories;

use App\TeacherDetails;

/**
 * Class TeacherDetailsRepository
 * @package App\Repositories
 */
class TeacherDetailsRepository extends CrudRepository
{
    /**
     * TeacherDetailsRepository constructor.
     * @param TeacherDetails $teacherDetails
     */
    public function __construct(TeacherDetails $teacherDetails)
    {
        parent::__construct($teacherDetails);
    }
}
