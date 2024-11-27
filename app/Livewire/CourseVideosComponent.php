<?php

namespace App\Livewire;

use App\Services\CourseService;
use App\Services\VideoService;
use Livewire\Component;

class CourseVideosComponent extends Component
{

    public $courseId;
    public $videos = [];
    public $comments = [];
    public $newComment = '';

    protected $videoService;
    protected $courseService;

    public function boot(VideoService $videoService, CourseService $courseService)
    {
        $this->videoService = $videoService;
        $this->courseService = $courseService;
    }

    public function mount($courseId=null)
    {
        $this->courseId = $courseId;
        $this->videos =  $this->videoService->getAllVideos(['categories','users'],['course_id'=>$this->courseId]);
       $this->calcProgressCourse();
    }
    public function calcProgressCourse()
    {
        $numTotalVideos =  count($this->videos);
        $numCompletedVideo=0;
        foreach ($this->videos as $video) {
            if (!empty($video['users'])) {
                foreach($video['users'] as $item){
                    $item['progress'] == 100 && $numCompletedVideo++;
                }
            }
        }
        $progressCourse =  $numTotalVideos == 0 ? 0 : ($numCompletedVideo*100)/$numTotalVideos ;
        $this->courseService->updateProgress($this->courseId,auth()->id(),$progressCourse);
    }

    public function goToVideo($videoId)
    {
        $videos = array_filter($this->videos, function ($video) use ($videoId) {
            return $video['id'] === $videoId;
        });
        $videos = array_values($videos);
        foreach ($videos as $video) {
            if (empty($video['users'])) {
                $this->videoService->saveVideo($videoId,auth()->id());
                break;
            }
        }
        return redirect()->route('video.view', ['videoId' => $videoId]);
    }

    public function render()
    {
        return view('livewire.course-videos-component');
    }
}
