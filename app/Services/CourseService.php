<?php

namespace App\Services;

use App\Contracts\CourseRepositoryInterface;
use App\Dtos\CourseDto;

class CourseService
{
    protected $courseRepository;

    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function getAllCourses(array $relations = []): array
    {
        return $this->courseRepository->all($relations);
    }

    public function searchCourses(array $filters)
    {
        return $this->courseRepository->searchCourses($filters);
    }

    public function findCourseById($id,array $relations = []): ?CourseDto
    {
        return $this->courseRepository->findById($id,$relations);
    }

    public function createCourse(CourseDto $data): ?CourseDto
    {
        return $this->courseRepository->create($data);
    }

    public function updateCourse($id, CourseDto $data): ?CourseDto
    {
        return $this->courseRepository->update($id, $data);
    }

    public function deleteCourse($id):bool
    {
        return $this->courseRepository->delete($id);
    }

    public function assignCourseToUser($courseId,$userId)
    {
        return $this->courseRepository->assignCourseToUser($courseId,$userId);
    }

    public function getCoursesByUser(int $userId): array
    {
        return $this->courseRepository->getCoursesByUser($userId);
    }

    public function updateProgress(int $courseId, int $userId, int $newProgress)
    {
        return $this->courseRepository->updateProgress($courseId,$userId,$newProgress);
    }

    public function getCourseDetailsWithUsers(int $courseId)
    {
        $course = $this->courseRepository->getUsersWithProgressAndVideos($courseId);

        if (!$course) {
            return null;
        }

        $users = $course->users->map(function ($user) use ($course) {
            $currentVideo = $course->videos->filter(function ($video) use ($user) {
                return $video->users->contains('id', $user->id);
            })->sortByDesc(function ($video) use ($user) {
                return $video->users->firstWhere('id', $user->id)->pivot->progress ?? 0;
            })->first();

            return [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'progress' => $user->pivot->progress,
                'current_video' => $currentVideo ? [
                    'id' => $currentVideo->id,
                    'title' => $currentVideo->title,
                    'progress' => $currentVideo->users->firstWhere('id', $user->id)->pivot->progress ?? 0,
                ] : null,
            ];
        });

        return [
            'course_name' => $course->name,
            'users' => $users
        ];
    }
}
