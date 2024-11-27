<?php

namespace Tests\Unit;

use App\Dtos\CourseDto;
use App\Models\Course;
use App\Repositories\CourseRepository;
use Mockery;
use PHPUnit\Framework\TestCase;
use Spatie\LaravelData\Data;

class CourseRepositoryTest extends TestCase
{

    protected $repository;
    protected $modelMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Simular el modelo Course
        $this->modelMock = Mockery::mock(Course::class);

        // Crear instancia del repositorio con el modelo simulado
        $this->repository = new CourseRepository($this->modelMock);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testSearchCourses()
    {
        $filters = [
            'name' => 'Laravel',
            'age_min' => 18,
            'category_id' => 1,
        ];

        $queryMock = Mockery::mock();
        $this->modelMock->shouldReceive('query')->andReturn($queryMock);

        // Simula condiciones
        $queryMock->shouldReceive('where')->with('name', 'like', '%Laravel%')->andReturnSelf();
        $queryMock->shouldReceive('where')->with('age_min', '>=', 18)->andReturnSelf();
        $queryMock->shouldReceive('whereHas')->andReturnSelf();
        $queryMock->shouldReceive('with')->with('categories')->andReturnSelf();
        $queryMock->shouldReceive('get')->andReturn(collect([]));

        $result = $this->repository->searchCourses($filters);

        $this->assertEquals([], $result);
    }


    public function testCreateCourse()
    {
        $data = Mockery::mock(Data::class);
        $data->categories = collect([(object)['id' => 1], (object)['id' => 2]]);

        $data->shouldReceive('toArray')->andReturn([
            'name' => 'Test Course',
            'age_min' => 18,
        ]);

        $this->modelMock->shouldReceive('fill')->with([
            'name' => 'Test Course',
            'age_min' => 18,
        ])->andReturnSelf();
        $this->modelMock->shouldReceive('save')->andReturn(true);
        $this->modelMock->shouldReceive('categories')->andReturnSelf();
        $this->modelMock->shouldReceive('attach')->with([1, 2]);

        $result = $this->repository->create($data);

        $this->assertInstanceOf(CourseDto::class, $result);
    }

    public function testUpdateCourse()
    {
        $data = Mockery::mock(Data::class);
        $data->categories = collect([(object)['id' => 1], (object)['id' => 3]]);
        $data->shouldReceive('toArray')->andReturn([
            'name' => 'Updated Course',
        ]);

        $course = Mockery::mock(Course::class);
        $this->modelMock->shouldReceive('find')->with(1)->andReturn($course);

        $course->shouldReceive('fill')->with(['name' => 'Updated Course'])->andReturnSelf();
        $course->shouldReceive('save')->andReturn(true);
        $course->shouldReceive('categories')->andReturnSelf();
        $course->shouldReceive('sync')->with([1, 3]);

        $dtoMock = Mockery::mock(CourseDto::class);
        //$this->repository->shouldReceive('toDto')->with($course)->andReturn($dtoMock);

        $result = $this->repository->update(1, $data);

        $this->assertInstanceOf(CourseDto::class, $result);
    }


}
