<?php

namespace Tests\Feature\app\Http\Controller\Admin;

use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * CreateBookingControllerTest
 * @package Tests\Feature\app\Http\Controllers\Admin
 * @author Juan Camilo Rosillo Martinez <juanca1158@hotmail.com>
 */
class CreateBookingControllerTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Test create booking activity success
     *
     * @return void
     */
    public function testCreateBooking(): void
    {
        $activity = Activity::factory()->create();

        $payload = [
            'activity_id' => $activity->id,
            'number_people' => 1,
            'price' => 35.2,
            'activity_date' => Carbon::now()->format('Y-m-d'),
        ];

        $response = $this->postJson(route('bookings.create'), $payload);
        $response->assertCreated();
        $response->assertJson(['message' => 'Reserva creada correctamente.']);

        $this->assertDatabaseHas('activity_bookings', $payload);
    }
}
