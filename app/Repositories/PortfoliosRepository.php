<?php
/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 31.03.18
 * Time: 15:45
 */

namespace App\Repositories;


use App\Portfolio;

class PortfoliosRepository extends Repository
{
 public function __construct(Portfolio $portfolio)
 {
     $this->model=$portfolio;
 }

}