<?php

namespace App\Repositories;

use App\Comment;

/**
 * Class CommentRepository
 * @package App\Repositories
 */
class CommentRepository extends CrudRepository
{
    /**
     * CommentRepository constructor.
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        parent::__construct($comment);
    }
}
