<?php

namespace App\Repositories\Interfaces;

/**
 * ActivityRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface ActivityRepositoryInterface
{

    /**
     * @param string $date
     * @param int $numberPeople
     * @return array
     */
    public function filter(string $date, int $numberPeople): array;
}
