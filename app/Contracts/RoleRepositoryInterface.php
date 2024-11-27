<?php

namespace App\Contracts;

use App\Dtos\CategoryDto;
use App\Dtos\RoleDto;
use Illuminate\Support\Collection;

interface RoleRepositoryInterface
{
    public function all(): array;

    public function create(RoleDto $data);

    public function assignRoleToUser(int $userId, int $roleId);

}
