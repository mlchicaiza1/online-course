<?php
namespace App\Dtos;

use Spatie\LaravelData\Data;
use Carbon\Carbon;

class UserDto extends Data
{
    public function __construct(
        public ?int $id= null,
        public ?string $name= null,
        public ?string $email= null,
        public ?int $progress= null,
        public ?int $like= null,
        public ?Carbon $createdAt = null,
        public ?Carbon $updatedAt = null,
    ) {}
}
