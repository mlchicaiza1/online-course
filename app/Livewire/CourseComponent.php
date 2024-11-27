<?php

namespace App\Livewire;

use App\Dtos\CategoryDto;
use App\Dtos\CourseDto;
use App\Services\CategoryService;
use App\Services\CourseService;
use Livewire\Component;

class CourseComponent extends Component
{
    public $courses,$categories, $name,$description,$age_min,$age_max,$courseId;
    public $selectedCategories = [];
    public $isEdit = false;

    protected $rules = [
        'name' => 'required:courses,name',
    ];

    protected $listeners = ['deleteCourse'];

    protected $courseService;
    protected $categoryService;


    public function boot(CourseService $courseService,CategoryService $categoryService)
    {
        $this->courseService = $courseService;
        $this->categoryService = $categoryService;
    }
    public function mount()
    {
        $this->loadCourses();
    }

    public function loadCourses()
    {
        $this->courses = $this->courseService->getAllCourses(['categories']);
        $this->categories = $this->categoryService->getAllCategories();
    }

    public function createCourse()
    {
        $this->validate();
        $this->courseService->createCourse(
            CourseDto::from([
                    'name' => $this->name,
                    'description' => $this->description,
                    'age_min' => $this->age_min,
                    'age_max' => $this->age_max,
                    'categories' => array_map(function ($categoryId) {
                        return CategoryDto::from(['id' => $categoryId]);
                    }, $this->selectedCategories),
                ]));

        $this->resetForm();
        $this->loadCourses();

        session()->flash('success', 'Course created successfully!');
    }

    public function editCourse($id)
    {
        $course = $this->courseService->findCourseById($id,['categories']);
        $this->courseId = $course->id;
        $this->name = $course->name;
        $this->description = $course->description;
        $this->age_min = $course->age_min;
        $this->age_max = $course->age_max;
        $this->selectedCategories = array_map(fn($category) => $category->id, $course->categories);
        $this->isEdit = true;
    }

    public function updateCourse()
    {
        $this->validate();

        $this->courseService->updateCourse($this->courseId,
            CourseDto::from(
                [
                    'name' => $this->name,
                    'description' => $this->description,
                    'age_min' => $this->age_min,
                    'age_max' => $this->age_max,
                    'categories' => array_map(function ($categoryId) {
                        return CategoryDto::from(['id' => $categoryId]);
                    }, $this->selectedCategories),
                ]
            ));

        $this->resetForm();
        $this->loadCourses();

        session()->flash('success', 'Course updated successfully!');
    }

    public function goToVideos($courseId)
    {
        return redirect()->route('videos.course', ['courseId' => $courseId]);
    }

    public function confirmDeleteCourse($id)
    {
        $this->dispatch('confirmDelete', id: $id);
    }

    public function deleteCourse($id)
    {
        $this->courseService->deleteCourse($id);

        $this->loadCourses();

        session()->flash('success', 'Course deleted successfully!');
    }

    public function resetForm()
    {
        $this->name = '';
        $this->description = '';
        $this->age_min = '';
        $this->age_max = '';
        $this->selectedCategories = [];
        $this->courseId = null;
        $this->isEdit = false;
    }

    public function render()
    {
        return view('livewire.course-component');
    }
}
