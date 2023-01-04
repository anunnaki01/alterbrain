<?php

namespace Tests\Unit\app\Repositories;

use App\Models\Activity;
use App\Repositories\EloquentActivityRepository;
use Carbon\Carbon;
use Tests\TestCase;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;

/**
 * EloquentActivityRepositoryTestCase
 * @package Tests\Unit\app\Repositories
 * @author Juan Camilo Rosillo Martinez <juanca1158@hotmail.com>
 */
class EloquentActivityRepositoryTest extends TestCase
{
    /**
     * @var Activity|LegacyMockInterface|MockInterface
     */
    protected Activity|LegacyMockInterface|MockInterface $activityMock;

    /**
     * @var EloquentActivityRepository
     */
    protected EloquentActivityRepository $eloquentActivityRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->activityMock = \Mockery::mock(Activity::class);
        $this->eloquentActivityRepository = new EloquentActivityRepository($this->activityMock);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Test get activity by id
     *
     * @return void
     */
    public function testGet(): void
    {
        $activity = Activity::factory()->make(['id' => 1])->toArray();

        $this->activityMock->shouldReceive('where')
            ->once()
            ->with('id', $activity['id'])
            ->andReturnSelf()
            ->getMock()
            ->shouldReceive('first')
            ->once()
            ->withNoArgs()
            ->andReturnSelf()
            ->getMock()
            ->shouldReceive('toArray')
            ->once()
            ->withNoArgs()
            ->andReturn($activity)
            ->getMock();

        $response = $this->eloquentActivityRepository->get($activity['id']);

        $this->assertEquals($activity, $response);
    }

    /**
     * Test filter al return pagination
     *
     * @return void
     */
    public function testFilter(): void
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

        $this->activityMock->shouldReceive('whereDate')
            ->once()
            ->with('init_date', '<=', $date)
            ->andReturnSelf()
            ->getMock()
            ->shouldReceive('whereDate')
            ->once()
            ->with('end_date', '>=', $date)
            ->andReturnSelf()
            ->getMock()
            ->shouldReceive('orderBy')
            ->once()
            ->with('popularity', 'desc')
            ->andReturnSelf()
            ->getMock()
            ->shouldReceive('paginate')
            ->once()
            ->with(10)
            ->andReturnSelf()
            ->getMock()
            ->shouldReceive('toArray')
            ->once()
            ->withNoArgs()
            ->andReturn($expected)
            ->getMock();

        $response = $this->eloquentActivityRepository->filter($date, $numberPeople);

        $this->assertEquals($expected, $response);
    }
}
