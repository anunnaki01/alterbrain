<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activities\FilterActivitiesRequest;
use App\Repositories\Interfaces\ActivityRepositoryInterface;
use Illuminate\Http\Response;

/**
 * ListActivitiesController
 * @package App\Http\Controllers\Admin
 * @author Juan Camilo Rosillo Martinez <juanca1158@hotmail.com>
 */
class GetActivityController extends Controller
{
    public function __construct(protected ActivityRepositoryInterface $activityRepository)
    {
    }

    /**
     * @param int $id
     * @return Response
     */
    public function __invoke(int $id): Response
    {
        try {
            return response($this->activityRepository->get($id));
        } catch (\Exception $exception) {
            return response(['error' => 'Ha ocurrido un error obteniendo la actividad'], 500);
        }
    }
}
