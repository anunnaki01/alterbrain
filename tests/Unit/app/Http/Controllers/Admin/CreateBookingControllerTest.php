<?php

namespace Tests\Unit\app\Http\Controllers\Admin;

use App\Http\Requests\Booking\CreateBookingRequest;
use App\Repositories\Interfaces\ActivityBookingRepositoryInterface;
use Carbon\Carbon;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use Tests\TestCase;

/**
 * CreateBookingControllerTest
 * @package Tests\Unit\app\Http\Controllers\Admin
 * @author Juan Camilo Rosillo Martinez <juanca1158@hotmail.com>
 */
class CreateBookingControllerTest extends TestCase
{
    /**
     * @var ActivityBookingRepositoryInterface|LegacyMockInterface|MockInterface
     */
    protected ActivityBookingRepositoryInterface|LegacyMockInterface|MockInterface $activityBookingRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->activityBookingRepositoryMock = \Mockery::mock(ActivityBookingRepositoryInterface::class);
        $this->requestMock = \Mockery::mock(CreateBookingRequest::class);

        $this->app->instance(ActivityBookingRepositoryInterface::class, $this->activityBookingRepositoryMock);
        $this->app->instance(CreateBookingRequest::class, $this->requestMock);
    }

    protected function tearDown(): void
    {
        $this->app->forgetInstance(ActivityBookingRepositoryInterface::class);
        $this->app->forgetInstance(CreateBookingRequest::class);
        parent::tearDown();
    }

    /**
     * Test create booking activity succcess
     *
     * @return void
     */
    public function testCreateBooking(): void
    {
        $payload = [
            'activity_id' => 1,
            'number_people' => 1,
            'price' => 35.2,
            'activity_date' => Carbon::now()->format('Y-m-d'),
        ];

        $this->requestMock->shouldReceive('validated')
            ->once()
            ->withNoArgs()
            ->andReturn($payload)
            ->getMock();

        $this->activityBookingRepositoryMock->shouldReceive('create')
            ->once()
            ->with($payload)
            ->getMock();

        $response = $this->postJson(route('bookings.create'), $payload);
        $response->assertCreated();
        $response->assertJson(['message' => 'Reserva creada correctamente.']);
    }

    /**
     * Test create booking activity error
     *
     * @return void
     */
    public function testCreateBookingError(): void
    {
        $this->requestMock->shouldReceive('validated')
            ->once()
            ->withNoArgs()
            ->andThrow(new \Exception('error'))
            ->getMock();

        $response = $this->postJson(route('bookings.create'));
        $response->assertServerError();
        $response->assertJson(['error' => 'Ha ocurrido un error creando la reserva.']);
    }
}
