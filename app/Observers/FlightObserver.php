<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;
use App\Models\Flight;

class FlightObserver
{
    /**
     * Handle the flight "created" event.
     *
     * @param  \App\Flight  $flight
     * @return void
     */
    public function created(Flight $flight)
    {
        Cache::forget('flights');
    }

    /**
     * Handle the flight "updated" event.
     *
     * @param  \App\Flight  $flight
     * @return void
     */
    public function updated(Flight $flight)
    {
        //
    }

    /**
     * Handle the flight "deleted" event.
     *
     * @param  \App\Flight  $flight
     * @return void
     */
    public function deleted(Flight $flight)
    {
        //
    }

    /**
     * Handle the flight "restored" event.
     *
     * @param  \App\Flight  $flight
     * @return void
     */
    public function restored(Flight $flight)
    {
        //
    }

    /**
     * Handle the flight "force deleted" event.
     *
     * @param  \App\Flight  $flight
     * @return void
     */
    public function forceDeleted(Flight $flight)
    {
        //
    }
}
