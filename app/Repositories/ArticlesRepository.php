<?php
/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 01.04.18
 * Time: 10:46
 */

namespace App\Repositories;


use App\Article;

class ArticlesRepository extends Repository
{
    public function __construct(Article $articles)
    {
        $this->model=$articles;
    }

}