<?php
/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 30.03.18
 * Time: 23:08
 */

namespace App\Repositories;
use App\Slider;

class SlidersRepository extends Repository
{
    public function __construct(Slider $slider)
    {
        $this->model=$slider;
    }

}