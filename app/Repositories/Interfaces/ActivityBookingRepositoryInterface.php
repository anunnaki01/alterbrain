<?php

namespace App\Repositories\Interfaces;

/**
 * BookingActivityRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface ActivityBookingRepositoryInterface
{
    /**
     * @param array $data
     * @return void
     */
    public function create(array $data): void;
}
