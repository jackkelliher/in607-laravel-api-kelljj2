<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;
use App\Models\Plane;

class PlaneObserver
{
    /**
     * Handle the plane "created" event.
     *
     * @param  \App\Plane  $plane
     * @return void
     */
    public function created(Plane $plane)
    {
        Cache::forget('planes');
    }

    /**
     * Handle the plane "updated" event.
     *
     * @param  \App\Plane  $plane
     * @return void
     */
    public function updated(Plane $plane)
    {
        //
    }

    /**
     * Handle the plane "deleted" event.
     *
     * @param  \App\Plane  $plane
     * @return void
     */
    public function deleted(Plane $plane)
    {
        //
    }

    /**
     * Handle the plane "restored" event.
     *
     * @param  \App\Plane  $plane
     * @return void
     */
    public function restored(Plane $plane)
    {
        //
    }

    /**
     * Handle the plane "force deleted" event.
     *
     * @param  \App\Plane  $plane
     * @return void
     */
    public function forceDeleted(Plane $plane)
    {
        //
    }
}
