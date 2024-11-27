<?php

namespace App\Contracts;

use App\Dtos\VideoDto;

interface VideoRepositoryInterface
{
    public function all(array $relations = [],array $filters = []): array;
    public function findById($id,array $relations = []);
    public function create(VideoDto $data);
    public function update($id, VideoDto $data) ;
    public function delete($id): bool;

    public function saveVideo(int $videoId, int $userId): void;
    public function getProgress($videoId, $userId);
    public function updateProgress(int $videoId, int $userId, int $progress): void;
    public function updateLike(int $videoId, int $userId, int $like): void;

    public function getViewCountByVideo(int $videoId): int;
    public function getAverageProgressByVideo(int $videoId): float;
    public function getLikesCountByVideo(int $videoId): int;
    public function getStatisticsByCourse(int $courseId);
    public function getVideoWithStatistics(int $videoId);
}
