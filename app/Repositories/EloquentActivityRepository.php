<?php

namespace App\Repositories;

use App\Models\Activity;
use App\Repositories\Interfaces\ActivityRepositoryInterface;

/**
 * EloquentActivityRepository
 * @package App\Repositories
 * @author Juan Camilo Rosillo Martinez <juanca1158@hotmail.com>
 */
class EloquentActivityRepository implements ActivityRepositoryInterface
{
    /**
     * @param Activity $activity
     */
    public function __construct(protected Activity $activity)
    {
    }

    /**
     * @param string $date
     * @param int $numberPeople
     * @return array
     */
    public function filter(string $date, int $numberPeople): array
    {
        return $this->activity->whereDate('init_date', '<=', $date)
            ->whereDate('end_date', '>=', $date)
            ->orderBy('popularity', 'desc')
            ->paginate(10)
            ->toArray();
    }
}
