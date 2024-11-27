<?php

namespace App\Contracts;

use App\Dtos\CommentDto;

interface CommentRepositoryInterface
{
    public function all(array $relations = []): array;
    public function findById($id,array $relations = []);
    public function create(CommentDto $data);
    public function update($id, CommentDto $data) ;
    public function delete($id): bool;
}
