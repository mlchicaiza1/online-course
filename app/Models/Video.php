<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['title', 'url', 'course_id'];


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'video_categories');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'video_user')
            ->withPivot('progress', 'like');
    }

    public function course()  {
        return $this->belongsTo(Course::class);
    }
}
