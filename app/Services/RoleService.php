<?php

namespace App\Services;

use App\Contracts\CategoryRepositoryInterface;
use App\Contracts\RoleRepositoryInterface;
use App\Dtos\CategoryDto;
use App\Dtos\RoleDto;

class RoleService
{
    protected $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getAllRoles()
    {
        return $this->roleRepository->all();
    }

    public function createRole(RoleDto $data)
    {
        return $this->roleRepository->create($data);
    }

    public function assignRoleToUser(int $userId, int $roleId)
    {
        return $this->roleRepository->assignRoleToUser($userId, $roleId);
    }

}
