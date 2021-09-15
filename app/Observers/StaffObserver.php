<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;
use App\Models\Staff;

class StaffObserver
{
    /**
     * Handle the staff "created" event.
     *
     * @param  \App\Staff  $staff
     * @return void
     */
    public function created(Staff $staff)
    {
        Cache::forget('staff');
    }

    /**
     * Handle the staff "updated" event.
     *
     * @param  \App\Staff  $staff
     * @return void
     */
    public function updated(Staff $staff)
    {
        //
    }

    /**
     * Handle the staff "deleted" event.
     *
     * @param  \App\Staff  $staff
     * @return void
     */
    public function deleted(Staff $staff)
    {
        //
    }

    /**
     * Handle the staff "restored" event.
     *
     * @param  \App\Staff  $staff
     * @return void
     */
    public function restored(Staff $staff)
    {
        //
    }

    /**
     * Handle the staff "force deleted" event.
     *
     * @param  \App\Staff  $staff
     * @return void
     */
    public function forceDeleted(Staff $staff)
    {
        //
    }
}
