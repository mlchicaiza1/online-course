<?php

namespace App\Livewire;

use App\Services\CourseService;
use Livewire\Component;

class AdminCourseDetailsComponent extends Component
{

    public $courseId;
    public $courseDetails = [];

    protected $courseService;

    public function boot(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function mount($courseId)
    {
        $this->courseId = $courseId;
        $this->loadCourseDetails();
    }

    public function loadCourseDetails()
    {
        $this->courseDetails = $this->courseService->getCourseDetailsWithUsers($this->courseId);
    }

    public function render()
    {
        return view('livewire.admin-course-details-component', [
            'courseDetails' => $this->courseDetails
        ]);
    }
}
