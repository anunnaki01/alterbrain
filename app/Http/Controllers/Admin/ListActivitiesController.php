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
class ListActivitiesController extends Controller
{
    public function __construct(protected ActivityRepositoryInterface $activityRepository)
    {
    }

    /**
     * @param FilterActivitiesRequest $request
     * @return Response
     */
    public function __invoke(FilterActivitiesRequest $request): Response
    {
        try {
            return response($this->activityRepository->filter($request->get('date'), $request->get('number_people')));
        } catch (\Exception $exception) {
            return response(['error' => 'Ha ocurrido un error obteniendo los registros'], 500);
        }
    }
}
