<?php

namespace App\Observers;

use App\Models\ImportDetail;

class ImportDetailObserver
{
    /**
     * Handle the ImportDetail "created" event.
     *
     * @param  \App\Models\ImportDetail  $importDetail
     * @return void
     */
    public function created(ImportDetail $importDetail)
    {
        //
    }

    /**
     * Handle the ImportDetail "updated" event.
     *
     * @param  \App\Models\ImportDetail  $importDetail
     * @return void
     */
    public function updated(ImportDetail $importDetail)
    {
        //
    }

    /**
     * Handle the ImportDetail "deleted" event.
     *
     * @param  \App\Models\ImportDetail  $importDetail
     * @return void
     */
    public function deleted(ImportDetail $importDetail)
    {
        //
    }

    /**
     * Handle the ImportDetail "restored" event.
     *
     * @param  \App\Models\ImportDetail  $importDetail
     * @return void
     */
    public function restored(ImportDetail $importDetail)
    {
        //
    }

    /**
     * Handle the ImportDetail "force deleted" event.
     *
     * @param  \App\Models\ImportDetail  $importDetail
     * @return void
     */
    public function forceDeleted(ImportDetail $importDetail)
    {
        //
    }
}
