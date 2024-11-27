<?php

namespace App\Repositories;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use App\Dtos\UserDto;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    protected function getDtoClass(): string
    {
        return UserDto::class;
    }

    public function getUserCourseIds(int $userId): array
    {

        $user = $this->model::findOrFail($userId);
        return $user->courses()->select('courses.id')->pluck('id')->toArray();
    }
}
