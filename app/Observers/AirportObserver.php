<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;
use App\Models\Airport;

class AirportObserver
{
    /**
     * Handle the airport "created" event.
     *
     * @param  \App\Airport  $airport
     * @return void
     */
    public function created(Airport $airport)
    {
        Cache::forget('airports');
    }

    /**
     * Handle the airport "updated" event.
     *
     * @param  \App\Airport  $airport
     * @return void
     */
    public function updated(Airport $airport)
    {
        //
    }

    /**
     * Handle the airport "deleted" event.
     *
     * @param  \App\Airport  $airport
     * @return void
     */
    public function deleted(Airport $airport)
    {
        //
    }

    /**
     * Handle the airport "restored" event.
     *
     * @param  \App\Airport  $airport
     * @return void
     */
    public function restored(Airport $airport)
    {
        //
    }

    /**
     * Handle the airport "force deleted" event.
     *
     * @param  \App\Airport  $airport
     * @return void
     */
    public function forceDeleted(Airport $airport)
    {
        //
    }
}
