<?php

namespace Tests\Unit\app\Repositories;

use App\Models\ActivityBooking;
use App\Repositories\EloquentActivityBookingRepository;
use Tests\TestCase;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;

/**
 * EloquentActivityBookingRepositoryTest
 * @package Tests\Unit\app\Repositories
 * @author Juan Camilo Rosillo Martinez <juanca1158@hotmail.com>
 */
class EloquentActivityBookingRepositoryTest extends TestCase
{
    /**
     * @var ActivityBooking|LegacyMockInterface|MockInterface
     */
    protected ActivityBooking|LegacyMockInterface|MockInterface $activityBookingMock;

    /**
     * @var EloquentActivityBookingRepository
     */
    protected EloquentActivityBookingRepository $activityBookingRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->activityBookingMock = \Mockery::mock(ActivityBooking::class);
        $this->activityBookingRepository = new EloquentActivityBookingRepository($this->activityBookingMock);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Test create booking call function for create
     *
     * @return void
     */
    public function testCreate(): void
    {
        $activityBooking = ActivityBooking::factory()->make(['activity_id' => 1]);

        $this->activityBookingMock->shouldReceive('create')
            ->once()
            ->with([
                'activity_id' => $activityBooking->activity_id,
                'number_people' => $activityBooking->number_people,
                'price' => $activityBooking->price,
                'activity_date' => $activityBooking->activity_date,
            ])
            ->andReturn($activityBooking);

        $this->activityBookingRepository->create($activityBooking->toArray());
    }
}
