<?php

namespace App\Livewire;

use App\Dtos\UserDto;
use App\Services\UserService;
use Livewire\Component;

class UserComponent extends Component
{
    public $users, $name,$email, $userId;
    public $isEdit = false;

    protected $rules = [
        'name' => 'required|unique:users,name',
    ];

    protected $listeners = ['deleteUser'];

    protected $userService;

    public function boot(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function mount()
    {
        $this->loadUsers();
    }

    public function loadUsers()
    {
        $this->users = $this->userService->getAllUsers();
    }

    public function createUser()
    {
        $this->validate();

        $this->userService->createUser(
            UserDto::from([
                'name' => $this->name,
                'email' => $this->email
            ]));

        $this->resetForm();
        $this->loadUsers();

        session()->flash('success', 'User created successfully!');
    }

    public function editUser($id)
    {
        $user = $this->userService->findUserById($id);

        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->isEdit = true;
    }

    public function updateUser()
    {
        $this->validate();

        $this->userService->updateUser($this->userId,
                UserDto::from([
                    'name' => $this->name,
                    'email' => $this->email
                ]));

        $this->resetForm();
        $this->loadUsers();

        session()->flash('success', 'User updated successfully!');
    }

    public function confirmDeleteUser($id)
    {
        $this->dispatch('confirmDelete', id: $id);
    }

    public function deleteUser($id)
    {
        $this->userService->deleteUser($id);

        $this->loadUsers();

        session()->flash('success', 'User deleted successfully!');
    }

    public function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->userId = null;
        $this->isEdit = false;
    }

    public function render()
    {
        return view('livewire.user-component');
    }
}
