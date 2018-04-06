<?php
/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 06.04.18
 * Time: 15:56
 */

namespace App\Repositories;


use App\Role;

class RolessReporitory extends Repository
{
    public function __construct(Role $role)
    {
        $this->model=$role;
    }
}