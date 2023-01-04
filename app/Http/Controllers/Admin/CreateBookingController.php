<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\CreateBookingRequest;
use App\Repositories\Interfaces\ActivityBookingRepositoryInterface;
use Illuminate\Http\Response;

/**
 * ListActivitiesController
 * @package App\Http\Controllers\Admin
 * @author Juan Camilo Rosillo Martinez <juanca1158@hotmail.com>
 */
class CreateBookingController extends Controller
{
    /**
     * @param ActivityBookingRepositoryInterface $bookingActivityRepository
     */
    public function __construct(protected ActivityBookingRepositoryInterface $bookingActivityRepository)
    {
    }

    /**
     * @param CreateBookingRequest $request
     * @return Response
     */
    public function __invoke(CreateBookingRequest $request): Response
    {
        try {
            $this->bookingActivityRepository->create($request->validated());
            return response(['message' => 'Reserva creada correctamente.'], Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            return response('Ha ocurrido un error creando la reserva.', 500);
        }
    }
}
