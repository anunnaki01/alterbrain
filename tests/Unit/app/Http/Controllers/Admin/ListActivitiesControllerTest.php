<?php

namespace Tests\Unit\app\Http\Controllers\Admin;

use App\Models\Activity;
use App\Repositories\Interfaces\ActivityRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use Tests\TestCase;

/**
 * ListActivitiesControllerTest
 * @package Tests\Unit\app\Http\Controllers\Admin
 * @author Juan Camilo Rosillo Martinez <juanca1158@hotmail.com>
 */
class ListActivitiesControllerTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * @var ActivityRepositoryInterface|LegacyMockInterface|MockInterface
     */
    protected ActivityRepositoryInterface|LegacyMockInterface|MockInterface $activityRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->activityRepositoryMock = \Mockery::mock(ActivityRepositoryInterface::class);
        $this->app->instance(ActivityRepositoryInterface::class, $this->activityRepositoryMock);
    }

    protected function tearDown(): void
    {
        $this->app->forgetInstance(ActivityRepositoryInterface::class);
        parent::tearDown();
    }


    /**
     * Test list activities for table
     *
     * @return void
     */
    public function testListActivities(): void
    {
        $date = Carbon::now()->format('Y-m-d');
        $numberPeople = 5;

        $activities = Activity::factory(3)->make([
            'init_date' => $date . ' 00:00:00',
            'end_date' => $date . ' 23:59:59',
            'popularity' => 5,
        ])->toArray();

        $expected = [
            "current_page" => 1,
            "data" => $activities,
            "first_page_url" => "http://localhost/activities/filter?page=1",
            "from" => 1,
            "last_page" => 1,
            "last_page_url" => "http://localhost/activities/filter?page=1",
            "links" => [
                [
                    "url" => null,
                    "label" => "&laquo; Previous",
                    "active" => false,
                ],
                [
                    "url" => "http://localhost/activities/filter?page=1",
                    "label" => "1",
                    "active" => true,
                ],
                [
                    "url" => null,
                    "label" => "Next &raquo;",
                    "active" => false,
                ],
            ],
            "next_page_url" => null,
            "path" => "http://localhost/activities/filter",
            "per_page" => 10,
            "prev_page_url" => null,
            "to" => 3,
            "total" => 3
        ];

        $this->activityRepositoryMock->shouldReceive('filter')
            ->once()
            ->with($date, $numberPeople)
            ->andReturn($expected)
            ->getMock();

        $response = $this->postJson(route('activities.filter'), [
            'date' => $date,
            'number_people' => $numberPeople,
        ]);

        $response->assertJson($expected);
    }

    /**
     * Test exception error list table
     *
     * @return void
     */
    public function testListException(): void
    {
        $date = Carbon::now()->format('Y-m-d');
        $numberPeople = 5;

        $this->activityRepositoryMock->shouldReceive('filter')
            ->once()
            ->with($date, $numberPeople)
            ->andThrow(new \Exception('error'))
            ->getMock();

        $response = $this->postJson(route('activities.filter'), [
            'date' => $date,
            'number_people' => $numberPeople,
        ]);

        $response->assertServerError();
        $response->assertJson(['error' => "Ha ocurrido un error obteniendo los registros"]);
    }
}
