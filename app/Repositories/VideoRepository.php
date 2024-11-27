<?php

namespace App\Repositories;

use App\Contracts\VideoRepositoryInterface;
use App\Models\Video;
use App\Dtos\VideoDto;
use App\Models\VideoUser;
use Spatie\LaravelData\Data;

class VideoRepository extends BaseRepository implements VideoRepositoryInterface
{
    public function __construct(Video $model)
    {
        parent::__construct($model);
    }

    protected function getDtoClass(): string
    {
        return VideoDto::class;
    }

    public function create(Data $data)
    {
        $category=[];
        $this->model->fill($data->toArray());
        $this->model->save();
        foreach ($data->categories as $key => $value) {
            $category[]=$value->id;
        }
        $this->model->categories()->attach($category);
        return $this->toDto($this->model);
    }

    public function update($id, Data $data)
    {
        $category=[];
        $this->model = $this->model->find($id);

        if ($this->model) {
            $dtoWithoutNulls = array_filter($data->toArray(), static function($value){ return isset($value); });
            $this->model->fill($dtoWithoutNulls)->save();

            foreach ($data->categories as $key => $value) {
                $category[]=$value->id;
            }
            $this->model->categories()->sync($category);

            return $this->toDto($this->model);
        }
        return null;
    }

    public function getVideosByCourse(int $courseId): array
    {
        $videos = $this->model
            ->where('course_id', $courseId)
            ->get();

        return $this->toDtoCollection($videos);
    }

    public function saveVideo(int $videoId, int $userId): void
    {
        $video = $this->model->findOrFail($videoId);
        $video->users()->attach($userId);
    }

    public function getProgress($videoId, $userId)
    {
        $videoUser = $this->model
            ->where('id', $videoId)
            ->with(['users' => function ($query) use ($userId) {
                $query->where('video_user.user_id', $userId)
                    ->select('users.id as user_id', 'users.name', 'video_user.progress as progress');
            }])
            ->first();

        return $videoUser && $videoUser->users->isNotEmpty()
            ? $videoUser->users->first()->progress
            : 0;
    }


    public function updateProgress(int $videoId, int $userId, int $progress): void
    {
        $video = $this->model->findOrFail($videoId);

        $video->users()->updateExistingPivot(
            $userId,
            ['progress' => $progress]
        );
    }

    public function updateLike(int $videoId, int $userId, int $like): void
    {
        $video = $this->model->findOrFail($videoId);

        $video->users()->updateExistingPivot(
            $userId,
            ['like' => $like]
        );
    }


    public function getViewCountByVideo(int $videoId): int
    {
        return VideoUser::where('video_id', $videoId)->count();
    }

    public function getAverageProgressByVideo(int $videoId): float
    {
        return VideoUser::where('video_id', $videoId)->avg('progress') ?? 0;
    }

    public function getLikesCountByVideo(int $videoId): int
    {
        return VideoUser::where('video_id', $videoId)->where('like', 1)->count();
    }

    public function getStatisticsByCourse(int $courseId)
    {
        return VideoUser::select('video_id')
            ->whereHas('video', function ($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->groupBy('video_id')
            ->selectRaw('video_id, COUNT(*) as views, AVG(progress) as average_progress, SUM(like) as total_likes')
            ->get();
    }

    public function getVideoWithStatistics(int $videoId)
    {
        return $this->model->with([
            'users' => function ($query) {
                $query->select('user_id', 'video_id', 'progress', 'like');
            }
        ])->where('id', $videoId)->first();
    }
}
