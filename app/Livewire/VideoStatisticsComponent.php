<?php

namespace App\Livewire;

use App\Services\VideoService;
use Livewire\Component;

class VideoStatisticsComponent extends Component
{
    public $videoId;
    public $statistics;

    protected $videoStatisticsService;

    public function boot(VideoService $videoStatisticsService)
    {
        $this->videoStatisticsService = $videoStatisticsService;
    }

    public function mount($videoId)
    {
        $this->videoId = $videoId;
        $this->loadStatistics();
    }

    public function loadStatistics()
    {
        $this->statistics = $this->videoStatisticsService->getVideoStatistics($this->videoId);
    }

    public function render()
    {
        return view('livewire.video-statistics-component', [
            'statistics' => $this->statistics,
        ]);
    }
}
