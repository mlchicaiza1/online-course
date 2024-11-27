<?php

namespace App\Repositories;

use App\Contracts\CategoryRepositoryInterface;
use App\Contracts\RoleRepositoryInterface;
use App\Models\Category;
use App\Dtos\CategoryDto;
use App\Dtos\RoleDto;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{

    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    protected function getDtoClass(): string
    {
        return RoleDto::class;
    }

    public function assignRoleToUser(int $userId, int $roleId)
    {
        $user = User::findOrFail($userId);
        $role = $this->model::findOrFail($roleId);

        return $user->assignRole($role);
    }


}
