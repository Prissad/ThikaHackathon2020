<?php

namespace App\Http\Controllers;

use App\Repositories\TeacherDetailsRepository;

class TeacherDetailsController extends CrudController
{

    /**
     * TeacherDetailsController constructor.
     * @param TeacherDetailsRepository $teacherDetailsRepository
     */

    public function __construct(TeacherDetailsRepository $teacherDetailsRepository)
    {
        $relations = [];
        $orderBy = [];
        $conditions = [];
        $nullConditions = [];
        $whereInConditions = [];
        $selectedAttributes = ['*'];
        parent::__construct($teacherDetailsRepository, $relations, $orderBy, $conditions, $nullConditions, $whereInConditions, $selectedAttributes);
    }
}
