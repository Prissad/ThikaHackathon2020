<?php

namespace App\Http\Controllers;

use App\Repositories\ClasseRepository;

class ClasseController extends CrudController
{

    /**
     * ClasseController constructor.
     * @param ClasseRepository $classeRepository
     */

    public function __construct(ClasseRepository $classeRepository)
    {
        $relations = ['subjects','live'];
        $orderBy = [];
        $conditions = [];
        $nullConditions = [];
        $whereInConditions = [];
        $selectedAttributes = ['*'];
        parent::__construct($classeRepository, $relations, $orderBy, $conditions, $nullConditions, $whereInConditions, $selectedAttributes);
    }
}
