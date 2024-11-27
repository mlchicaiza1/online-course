<?php

namespace App\Contracts;

use App\Dtos\UserDto;

interface UserRepositoryInterface
{
    public function all(): array;
    public function findById($id);
    public function create(UserDto $data);
    public function update($id, UserDto $data) ;
    public function delete($id): bool;
    public function getUserCourseIds(int $userId): array;
}
