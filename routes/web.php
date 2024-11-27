<?php

use App\Livewire\AdminCourseDetailsComponent;
use App\Livewire\CategoryComponent;
use App\Livewire\CommentComponent;
use App\Livewire\CourseComponent;
use App\Livewire\CourseVideosComponent;
use App\Livewire\RolesManager;
use App\Livewire\UserComponent;
use App\Livewire\UserCoursesComponent;
use App\Livewire\VideoComponent;
use App\Livewire\VideoStatisticsComponent;
use App\Livewire\ViewVideoComponent;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/categories', CategoryComponent::class)->name('categories.index');
    Route::get('/course', CourseComponent::class)->name('course.index');
    Route::get('/comment', CommentComponent::class)->name('comment.index');
    Route::get('/user', UserComponent::class)->name('user.index');
    Route::get('/videos', VideoComponent::class)->name('video.index');

    Route::get('/videos/{courseId}', VideoComponent::class)->name('videos.course');

    Route::get('/me-course', UserCoursesComponent::class)->name('user.courses');
    Route::get('/course/{courseId}/videos', CourseVideosComponent::class)->name('course.videos');

    Route::get('/video/{videoId}/view', ViewVideoComponent::class)->name('video.view');

    Route::get('/roles', RolesManager::class)->name('rol');

    Route::get('/admin/course/{courseId}/details', AdminCourseDetailsComponent::class)->name('admin.course');

    Route::get('/videos-statics/{videoId}', VideoStatisticsComponent::class)->name('videos.statics');
});

