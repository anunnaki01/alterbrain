<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ListActivitiesController;
use App\Http\Controllers\Admin\GetActivityController;
use App\Http\Controllers\Admin\CreateBookingController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('activities')->group(function () {
    Route::post('filter', [ListActivitiesController::class, '__invoke'])->name('activities.filter');
    Route::get('get/{id}', [GetActivityController::class, '__invoke'])->name('activities.get');
});

Route::prefix('bookings')->group(function () {
    Route::post('create', [CreateBookingController::class, '__invoke'])->name('bookings.create');
});
