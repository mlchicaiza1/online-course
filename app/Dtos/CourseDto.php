<?php

namespace App\Dtos;

use Spatie\LaravelData\Data;
use Carbon\Carbon;
use Spatie\LaravelData\DataCollection;

class CourseDto extends Data
{
    public function __construct(
        public ?int $id= null,
        public ?string $name= null,
        public ?string $description= null,
        public ?int $age_min= null,
        public ?int $age_max= null,

        /** @var CategoryDto[] */
        public ?array $categories=null,
        /** @var UserDto[] */
        public ?array $users=null,
        public ?Carbon $createdAt = null,
        public ?Carbon $updatedAt = null,


    ) {}
}
