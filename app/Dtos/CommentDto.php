<?php

namespace App\Dtos;

use Spatie\LaravelData\Data;
use Carbon\Carbon;

class CommentDto extends Data
{

    public function __construct(
        public ?int $id = null,
        public ?int $video_id = null,
        public ?int $user_id = null,
        public ?string $comment = null,
        public ?string $state = null,
        public ?UserDto $user=null,
        public ?VideoDto $video=null,
        public ?Carbon $createdAt = null,
        public ?Carbon $updatedAt = null,
    )
    {}

}
