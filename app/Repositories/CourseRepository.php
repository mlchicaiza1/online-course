<?php

namespace App\Repositories;

use App\Contracts\CourseRepositoryInterface;
use App\Models\Course;
use App\Dtos\CourseDto;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\Data;

class CourseRepository extends BaseRepository implements CourseRepositoryInterface
{
    public function __construct(Course $model)
    {
        parent::__construct($model);
    }

    protected function getDtoClass(): string
    {
        return CourseDto::class;
    }

    public function searchCourses(array $filters)
    {
        $query = $this->model->query();
        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }
        if (!empty($filters['age_min'])) {
            $query->where('age_min', '>=', $filters['age_min']);
        }

        if (!empty($filters['age_max'])) {
            $query->where('age_max', '<=', $filters['age_max']);
        }
        if (!empty($filters['category_id'])) {
            $categoryId = $filters['category_id'];
            $query ->whereHas('categories', function ($query) use ($categoryId) {
                $query->where('categories.id', $categoryId);
            });
        }

        return  $this->toDtoCollection($query->with('categories')->get());
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

    public function assignCourseToUser($courseId, $userId)
    {
        $this->model = $this->model->find($courseId);
        if ($this->model) {
            $this->model->users()->attach($userId);
            return $this->toDto($this->model);
        }
        return null;
    }

    public function getCoursesByUser(int $userId): array
    {
        $courses = $this->model
            ->whereHas('users', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->with('categories','users')
            ->get();
        return $this->toDtoCollection($courses);
    }

    public function updateProgress(int $courseId, int $userId, int $newProgress): void
    {
        $course = $this->model->findOrFail($courseId);

        $course->users()->updateExistingPivot(
            $userId,
            ['progress' => min($newProgress, 100)]
        );
    }

    public function getUsersWithProgressAndVideos(int $courseId)
    {
        return $this->model->where('id', $courseId)
            ->with([
                'users' => function ($query) {
                    $query->withPivot('progress');
                },
                'videos' => function ($query) {
                    $query->with([
                        'users' => function ($userQuery) {
                            $userQuery->select('users.id', 'users.name')
                                ->withPivot('progress');
                        }
                    ]);
                }
            ])->first();
    }
}
