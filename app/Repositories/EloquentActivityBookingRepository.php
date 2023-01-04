<?php

namespace App\Repositories;

use App\Models\Activity;
use App\Models\ActivityBooking;
use App\Repositories\Interfaces\ActivityBookingRepositoryInterface;

/**
 * EloquentBookingActivityRepository
 * @package App\Repositories
 * @author Juan Camilo Rosillo Martinez <juanca1158@hotmail.com>
 */
class EloquentActivityBookingRepository implements ActivityBookingRepositoryInterface
{
    /**
     * @param ActivityBooking $booking
     */
    public function __construct(protected ActivityBooking $booking)
    {
    }

    /**
     * @param array $data
     * @return void
     */
    public function create(array $data): void
    {
        $this->booking->create([
            'activity_id' => $data['activity_id'],
            'number_people' => $data['number_people'],
            'price' => $data['price'],
            'activity_date' => $data['activity_date'],
        ]);
    }
}
