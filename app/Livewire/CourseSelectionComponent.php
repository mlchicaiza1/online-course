<?php

namespace App\Livewire;

use App\Services\CategoryService;
use App\Services\CourseService;
use App\Services\UserService;
use Livewire\Component;

class CourseSelectionComponent extends Component
{

    public $name,$age_min,$age_max,$category_id,$categories;
    public $courses = [];
    public $selectedCourseId;
    public $userCourseIds;

    protected $courseService;
    protected $userService;
    protected $categoryService;

    public function boot(CourseService $courseService, UserService $userService,CategoryService $categoryService)
    {
        $this->courseService = $courseService;
        $this->userService=$userService;
        $this->categoryService=$categoryService;
    }

    public function mount()
    {
        $this->categories = $this->categoryService->getAllCategories();
        $this->courses = $this->courseService->getAllCourses(['users']);
        $this->userCourseIds = $this->userService->getUserCourseIds(auth()->id());

    }

    public function selectCourse($courseId)
    {
        $this->selectedCourseId = $courseId;
        $this->courseService->assignCourseToUser($courseId,auth()->id());
        $this->dispatch('course-selected', [
            'message' => 'Curso seleccionado con éxito!',
        ]);
    }

    public function adminCourse($courseId) {
        return redirect()->route('admin.course', ['courseId' => $courseId]);
    }

    public function search()
    {
        $filters = [
            'name' => $this->name,
            'age_min' => $this->age_min,
            'age_max' => $this->age_max,
            'category_id' => $this->category_id,
        ];

        $this->courses = $this->courseService->searchCourses($filters);
    }

    public function render()
    {
        return view('livewire.course-selection-component');
    }
}
