<?php

namespace App\Dtos;

use Spatie\LaravelData\Data;
use Carbon\Carbon;

class VideoDto extends Data
{
    public function __construct(
        public ?int $id= null,
        public ?int $course_id = null,
        public ?string $title= null,
        public ?string $url= null,
         /** @var CategoryDto[] */
        public ?array $categories=null,
          /** @var CommentDto[] */
        public ?array $comments=null,
        /** @var UserDto[] */
        public ?array $users=null,
        public ?Carbon $createdAt = null,
        public ?Carbon $updatedAt = null,
    ) {}
}
