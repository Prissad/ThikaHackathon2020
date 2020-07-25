<?php

namespace App\Repositories;

use App\Admin;

/**
 * Class AdminRepository
 * @package App\Repositories
 */
class AdminRepository extends CrudRepository
{
    /**
     * AdminRepository constructor.
     * @param Admin $admin
     */
    public function __construct(Admin $admin)
    {
        parent::__construct($admin);
    }
}
