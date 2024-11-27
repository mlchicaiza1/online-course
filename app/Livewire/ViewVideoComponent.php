<?php

namespace App\Livewire;

use App\Dtos\CommentDto;
use App\Services\CommentService;
use App\Services\VideoService;
use Livewire\Component;

class ViewVideoComponent extends Component
{
    public $videoId;
    public $video;
    public $comments = [];
    public $commentContent;
    public $progress;
    public $isLiked = false;

    protected $videoService;
    protected $commentService;



    public function boot(VideoService $videoService, CommentService $commentService)
    {
        $this->videoService = $videoService;
        $this->commentService = $commentService;
    }

    public function mount($videoId)
    {
        $this->videoId = $videoId;
        $this->loadVideos();
    }

    public function loadVideos(){
        $this->video =  $this->videoService->findVideoById($this->videoId,['comments','users'])->toArray();
        $this->progress = $this->videoService->getProgress($this->videoId,auth()->id());
        if (is_array($this->video['comments'])) {
            $this->comments = array_map(fn($comment) => $comment, $this->video['comments']);
        }
        $this->isLiked = $this->video['users'][0]['like'];
    }

    public function addComment()
    {
        $this->commentService->createComment(
            CommentDto::from([
                'user_id' =>auth()->id(),
                'video_id' => $this->videoId,
                'state'=>'pendiente',
                'comment' => $this->commentContent,
            ]));

        $this->commentContent='';
        $this->loadVideos();
    }

    public function VideoCompleted()
    {
        $this->progress=100;
        $this->videoService->updateProgress( $this->videoId,auth()->id(), $this->progress);
        $this->loadVideos();
    }

    public function toggleLike()
    {
        $this->videoService->updateLike($this->videoId,auth()->id(),!$this->isLiked);
        $this->isLiked = !$this->isLiked;
    }

    public function render()
    {
        return view('livewire.view-video-component');
    }
}
