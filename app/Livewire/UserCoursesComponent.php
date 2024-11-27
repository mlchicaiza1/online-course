<?php

namespace App\Livewire;

use App\Services\CourseService;
use Livewire\Component;

class UserCoursesComponent extends Component
{

    public $courses;
    protected $courseService;

    public function boot(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function mount()
    {

        $this->courses = $this->courseService->getCoursesByUser(auth()->id());
    }

    public function goToVideos($courseId)
    {
        return redirect()->route('course.videos', ['courseId' => $courseId]);
    }

    public function render()
    {
        return view('livewire.user-courses-component');
    }
}
