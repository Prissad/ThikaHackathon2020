<?php

namespace App\Repositories;

use App\Classe;

/**
 * Class ClasseRepository
 * @package App\Repositories
 */
class ClasseRepository extends CrudRepository
{
    /**
     * ClasseRepository constructor.
     * @param Classe $classe
     */
    public function __construct(Classe $classe)
    {
        parent::__construct($classe);
    }
}
