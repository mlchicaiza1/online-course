<?php

namespace App\Services;

use App\Contracts\CommentRepositoryInterface;
use App\Dtos\CommentDto;

class CommentService
{
    protected $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function getAllComments(array $relations = []): array
    {
        return $this->commentRepository->all($relations);
    }

    public function findCommentById($id,array $relations = []): ?CommentDto
    {
        return $this->commentRepository->findById($id,$relations);
    }

    public function createComment(CommentDto $data): ?CommentDto
    {
        return $this->commentRepository->create($data);
    }

    public function updateComment($id, CommentDto $data): ?CommentDto
    {
        return $this->commentRepository->update($id, $data);
    }

    public function deleteComment($id):bool
    {
        return $this->commentRepository->delete($id);
    }
}
