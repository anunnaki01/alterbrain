<?php

namespace App\Providers;

use App\Repositories\EloquentActivityRepository;
use App\Repositories\EloquentActivityBookingRepository;
use App\Repositories\Interfaces\ActivityRepositoryInterface;
use App\Repositories\Interfaces\ActivityBookingRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @var string[]
     */
    public $bindings = [
        ActivityRepositoryInterface::class => EloquentActivityRepository::class,
        ActivityBookingRepositoryInterface::class => EloquentActivityBookingRepository::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
