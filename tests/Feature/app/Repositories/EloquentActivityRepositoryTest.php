<?php

namespace Tests\Feature\app\Repositories;

use App\Models\Activity;
use App\Repositories\EloquentActivityRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * EloquentActivityRepositoryTestCase
 * @package Tests\Unit\app\Repositories
 * @author Juan Camilo Rosillo Martinez <juanca1158@hotmail.com>
 */
class EloquentActivityRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var EloquentActivityRepository
     */
    protected EloquentActivityRepository $eloquentActivityRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->eloquentActivityRepository = new EloquentActivityRepository(new Activity());
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
        $activity = Activity::factory()
            ->create()
            ->toArray();

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

        $activities = Activity::factory(3)->create([
            'init_date' => $date . ' 00:00:00',
            'end_date' => $date . ' 23:59:59',
            'popularity' => 5,
        ])->toArray();

        $response = $this->eloquentActivityRepository->filter($date, $numberPeople);

        $this->assertEquals($activities, $response['data']);
    }
}
