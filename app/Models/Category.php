<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = ['name'];

    public function courses(){
        return $this->belongsToMany(Course::class,'course_categories');
    }

    public function videos(){
        return $this->belongsToMany(Video::class,'video_categories');
    }
}
