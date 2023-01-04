<?php

namespace Tests\Unit\app\Http\Controllers\Admin;

use App\Models\Activity;
use App\Repositories\Interfaces\ActivityRepositoryInterface;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use Tests\TestCase;

/**
 * ListActivitiesControllerTest
 * @package Tests\Unit\app\Http\Controllers\Admin
 * @author Juan Camilo Rosillo Martinez <juanca1158@hotmail.com>
 */
class GetActivityControllerTest extends TestCase
{
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
     * Test get activity data by id
     *
     * @return void
     */
    public function testGetActivity(): void
    {
        $activity = Activity::factory()->make(['id' => 1])->toArray();

        $this->activityRepositoryMock->shouldReceive('get')
            ->once()
            ->with($activity['id'])
            ->andReturn($activity)
            ->getMock();

        $response = $this->getJson(route('activities.get', ['id' => $activity['id']]));
        $response->assertSuccessful();
        $response->assertJson($activity);
    }

    /**
     * Test get error activity data by id
     *
     * @return void
     */
    public function testGetActivityExceptionError(): void
    {
        $this->activityRepositoryMock->shouldReceive('get')
            ->once()
            ->with(1)
            ->andThrow(new \Exception('error'))
            ->getMock();

        $response = $this->getJson(route('activities.get', ['id' =>1]));
        $response->assertServerError();
        $response->assertJson(['error' => 'Ha ocurrido un error obteniendo la actividad']);
    }
}
