<?php

namespace App\Services;

use App\Contracts\VideoRepositoryInterface;
use App\Dtos\VideoDto;

class VideoService
{
    protected $videoRepository;

    public function __construct(VideoRepositoryInterface $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function getAllVideos(array $relations = [],array $filters = []): array
    {
        return $this->videoRepository->all($relations,$filters);
    }

    public function findVideoById($id,array $relations = []): ?VideoDto
    {
        return $this->videoRepository->findById($id,$relations);
    }

    public function createVideo(VideoDto $data): ?VideoDto
    {
        return $this->videoRepository->create($data);
    }

    public function updateVideo($id, VideoDto $data): ?VideoDto
    {
        return $this->videoRepository->update($id, $data);
    }

    public function deleteVideo($id):bool
    {
        return $this->videoRepository->delete($id);
    }

    public function saveVideo(int $videoId, int $userId)
    {
        return $this->videoRepository->saveVideo($videoId,$userId);
    }

    public function getProgress($videoId, $userId)
    {
        return $this->videoRepository->getProgress($videoId,$userId);
    }

    public function updateProgress(int $videoId, int $userId, int $progress)
    {
        return $this->videoRepository->updateProgress($videoId,$userId,$progress);
    }

    public function updateLike(int $videoId, int $userId, int $like)
    {
        return $this->videoRepository->updateLike($videoId,$userId,$like);
    }

    public function getVideoStatistics(int $videoId): array
    {
        return [
            'views' => $this->videoRepository->getViewCountByVideo($videoId),
            'average_progress' => $this->videoRepository->getAverageProgressByVideo($videoId),
            'likes' => $this->videoRepository->getLikesCountByVideo($videoId),
        ];
    }

    public function getCourseVideoStatistics(int $courseId)
    {
        return $this->videoRepository->getStatisticsByCourse($courseId);
    }

    public function getVideoDetails(int $videoId)
    {
        return $this->videoRepository->getVideoWithStatistics($videoId);
    }
}
