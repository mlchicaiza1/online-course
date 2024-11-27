<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name','description','age_min','age_max'];

    public function categories(){
        return $this->belongsToMany(Category::class,'course_categories');
    }

    public function users(){
        return $this->belongsToMany(User::class,'course_user')->withPivot('progress');
    }

    public function videos(){
        return $this->hasMany(Video::class);
    }
}
