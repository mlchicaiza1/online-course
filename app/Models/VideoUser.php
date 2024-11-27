<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoUser extends Model
{
    protected $table = "video_user";
    protected $fillable = ['user_id', 'video_id', 'progress', 'like'];
}
