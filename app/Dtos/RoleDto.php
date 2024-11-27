<?php

namespace App\Dtos;

use Spatie\LaravelData\Data;
use Carbon\Carbon;

class RoleDto extends Data
{

    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
        public ?Carbon $createdAt = null,
        public ?Carbon $updatedAt = null,
    )
    {}

}
