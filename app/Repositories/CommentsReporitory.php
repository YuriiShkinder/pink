<?php
/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 01.04.18
 * Time: 17:37
 */

namespace App\Repositories;


use App\Comment;

class CommentsReporitory extends Repository
{
    public function __construct(Comment $comment)
    {
        $this->model=$comment;
    }

}