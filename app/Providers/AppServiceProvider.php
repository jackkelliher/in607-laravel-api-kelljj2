<?php

namespace App\Providers;

use App\Models\Airport;
use App\Observers\AirportObserver;
use App\Models\Customer;
use App\Observers\CustomerObserver;
use App\Models\Flight;
use App\Observers\FlightObserver;
use App\Models\Plane;
use App\Observers\PlaneObserver;
use App\Models\Staff;
use App\Observers\StaffObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
        Airport::observe(AirportObserver::class);
        Customer::observe(CustomerObserver::class);
        Flight::observe(FlightObserver::class);
        Plane::observe(PlaneObserver::class);
        Staff::observe(StaffObserver::class);
    }
}
