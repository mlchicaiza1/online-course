<?php

namespace App\Livewire;

use App\Dtos\RoleDto;
use App\Services\RoleService;
use App\Services\UserService;
use Livewire\Component;

class RolesManager extends Component
{
    public $roles, $roleName, $users;

    protected $roleService;
    protected $userService;

    public function boot(RoleService $roleService, UserService $userService)
    {
        $this->roleService = $roleService;
        $this->userService = $userService;

    }
    public function mount()
    {
        $this->roles = $this->roleService->getAllRoles();
        $this->users = $this->userService->getAllUsers();
    }

    public function createRole()
    {
        $this->validate(['roleName' => 'required|unique:roles,name']);
        $this->roleService->createRole(
            RoleDto::from([
                'name' =>$this->roleName
            ])
        );
        $this->roles = $this->roleService->getAllRoles();
        $this->roleName = '';
        session()->flash('message', '¡Rol creado exitosamente!');
    }

    public function assignRole($userId, $roleId)
    {
        $this->roleService->assignRoleToUser($userId, $roleId);
        session()->flash('message', '¡Rol asignado exitosamente!');
    }

    public function render()
    {
        return view('livewire.roles-manager');
    }
}
