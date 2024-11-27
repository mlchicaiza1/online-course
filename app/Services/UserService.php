<?php

namespace App\Services;

use App\Contracts\UserRepositoryInterface;
use App\Dtos\UserDto;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers(): array
    {
        return $this->userRepository->all();
    }

    public function findUserById($id): ?UserDto
    {
        return $this->userRepository->findById($id);
    }

    public function createUser(UserDto $data): ?UserDto
    {
        return $this->userRepository->create($data);
    }

    public function updateUser($id, UserDto $data): ?UserDto
    {
        return $this->userRepository->update($id, $data);
    }

    public function deleteUser($id):bool
    {
        return $this->userRepository->delete($id);
    }

    public function getUserCourseIds(int $userId)
    {
        return $this->userRepository->getUserCourseIds($userId);
    }

}
