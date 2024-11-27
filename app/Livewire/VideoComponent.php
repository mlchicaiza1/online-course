<?php

namespace App\Livewire;

use App\Dtos\CategoryDto;
use App\Dtos\VideoDto;
use App\Services\CategoryService;
use App\Services\VideoService;
use Livewire\Component;

class VideoComponent extends Component
{
    public $videos,$categories, $title,$url, $videoId, $courseId;
    public $selectedCategories = [];
    public $isEdit = false;

    protected $rules = [
        'title' => 'required:videos,title',
    ];

    protected $listeners = ['deleteVideo','courseSelected'];

    protected $videoService;
    protected $categoryService;

    public function boot(VideoService $videoService,CategoryService $categoryService)
    {
        $this->videoService = $videoService;
        $this->categoryService = $categoryService;
    }
    public function mount($courseId=null)
    {
        $this->courseId = $courseId;
        $this->loadVideos();
    }

    public function loadVideos()
    {
        $this->videos = $this->videoService->getAllVideos(
            ['categories'],
            !isset($this->courseId)?
            []:['course_id'=>$this->courseId]);
        $this->categories = $this->categoryService->getAllCategories();
    }

    public function createVideo()
    {
        $this->validate();

        $this->videoService->createVideo(
            VideoDto::from([
                'title' => $this->title,
                'url' => $this->url,
                'course_id' => $this->courseId,
                'categories' => array_map(function ($categoryId) {
                    return CategoryDto::from(['id' => $categoryId]);
                }, $this->selectedCategories),
                ]));

        $this->resetForm();
        $this->loadVideos();

        session()->flash('success', 'Video created successfully!');
    }

    public function editVideo($id)
    {
        $video = $this->videoService->findVideoById($id,['categories']);

        $this->videoId = $video->id;
        $this->title = $video->title;
        $this->url = $video->url;
        $this->selectedCategories = array_map(fn($category) => $category->id, $video->categories);
        $this->isEdit = true;
    }

    public function updateVideo()
    {
        $this->validate();

        $this->videoService->updateVideo($this->videoId,
                VideoDto::from([
                    'title' => $this->title,
                    'url' => $this->url,
                    'courseId' => $this->courseId,
                    'categories' => array_map(function ($categoryId) {
                        return CategoryDto::from(['id' => $categoryId]);
                    }, $this->selectedCategories),
                ]));

        $this->resetForm();
        $this->loadVideos();

        session()->flash('success', 'Video updated successfully!');
    }

    public function confirmDeleteVideo($id)
    {
        $this->dispatch('confirmDelete', id: $id);
    }

    public function deleteVideo($id)
    {
        $this->videoService->deleteVideo($id);

        $this->loadVideos();

        session()->flash('success', 'Video deleted successfully!');
    }

    public function resetForm()
    {
        $this->title = '';
        $this->url = '';
        $this->videoId = null;
        $this->selectedCategories = [];
        $this->isEdit = false;
    }

    public function goToStats($videoId)
    {
        return redirect()->route('videos.statics', ['videoId' => $videoId]);
    }
    public function render()
    {
        return view('livewire.video-component');
    }
}
