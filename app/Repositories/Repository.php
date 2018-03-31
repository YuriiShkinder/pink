<?php
/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 30.03.18
 * Time: 17:09
 */

namespace App\Repositories;
use Config;

abstract class Repository{
protected $model;

public function get(){
    $builder=$this->model->select('*');

    return $builder->get();
}

}