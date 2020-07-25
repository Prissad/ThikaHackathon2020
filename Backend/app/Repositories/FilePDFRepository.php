<?php

namespace App\Repositories;

use App\FilePDF;

/**
 * Class FilePDFRepository
 * @package App\Repositories
 */
class FilePDFRepository extends CrudRepository
{
    /**
     * FilePDFRepository constructor.
     * @param FilePDF $filePDF
     */
    public function __construct(FilePDF $filePDF)
    {
        parent::__construct($filePDF);
    }
}
