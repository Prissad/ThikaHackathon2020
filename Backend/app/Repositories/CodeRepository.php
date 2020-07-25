<?php

namespace App\Repositories;

use App\Code;

/**
 * Class CodeRepository
 * @package App\Repositories
 */
class CodeRepository extends CrudRepository
{
    /**
     * CodeRepository constructor.
     * @param Code $code
     */
    public function __construct(Code $code)
    {
        parent::__construct($code);
    }
}
