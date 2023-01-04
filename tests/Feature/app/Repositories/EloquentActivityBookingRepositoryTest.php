<?php

namespace Tests\Feature\app\Repositories;

use App\Models\ActivityBooking;
use App\Repositories\EloquentActivityBookingRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * EloquentActivityBookingRepositoryTest
 * @package Tests\Feature\app\Repositories
 * @author Juan Camilo Rosillo Martinez <juanca1158@hotmail.com>
 */
class EloquentActivityBookingRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var EloquentActivityBookingRepository
     */
    protected EloquentActivityBookingRepository $activityBookingRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->activityBookingRepository = new EloquentActivityBookingRepository(new ActivityBooking());
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
        $activityBooking = ActivityBooking::factory()->make();

        $this->activityBookingRepository->create([
            'activity_id' => $activityBooking->activity_id,
            'number_people' => $activityBooking->number_people,
            'price' => $activityBooking->price,
            'activity_date' => $activityBooking->activity_date,
        ]);

        $this->assertDatabaseHas('activity_bookings', $activityBooking->toArray());
    }
}
