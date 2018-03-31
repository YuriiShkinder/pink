<?php
/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 30.03.18
 * Time: 17:06
 */
namespace App\Repositories;

use App\Menu;
class MenusRepository extends Repository {

    public function __construct(Menu $menu)
    {
        $this->model=$menu;
    }

}