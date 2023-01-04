<?php

namespace Tests\Feature\app\Http\Controller\Admin;

use App\Models\Activity;
use App\Repositories\Interfaces\ActivityRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use Tests\TestCase;

/**
 * ListActivitiesControllerTest
 * @package Tests\Feature\app\Http\Controllers\Admin
 * @author Juan Camilo Rosillo Martinez <juanca1158@hotmail.com>
 */
class GetActivityControllerTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Test get activity data by id
     *
     * @return void
     */
    public function testGetActivity(): void
    {
        $activity = Activity::factory()
            ->create()
            ->toArray();

        $response = $this->getJson(route('activities.get', ['id' => $activity['id']]));
        $response->assertSuccessful();
        $response->assertJson($activity);
    }
}
