<?php

namespace App\Contracts;

use App\Dtos\CourseDto;

interface CourseRepositoryInterface
{
    public function all(array $relations = []): array;
    public function searchCourses(array $filters);
    public function findById($id,array $relations = []);
    public function create(CourseDto $data);
    public function update($id, CourseDto $data) ;
    public function delete($id): bool;

    public function assignCourseToUser($courseId,$userId);
    public function getCoursesByUser(int $userId): array;

    public function updateProgress(int $courseId, int $userId, int $newProgress): void;

    public function getUsersWithProgressAndVideos(int $courseId);
}
