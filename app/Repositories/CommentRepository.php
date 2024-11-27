<?php

namespace App\Repositories;
use App\Contracts\CommentRepositoryInterface;
use App\Dtos\CommentDto;
use App\Models\Comment;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }

    protected function getDtoClass(): string
    {
        return CommentDto::class;
    }
}
