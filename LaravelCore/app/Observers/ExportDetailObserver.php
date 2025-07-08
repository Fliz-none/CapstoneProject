<?php

namespace App\Observers;

use App\Models\ExportDetail;

class ExportDetailObserver
{
    /**
     * Handle the ExportDetail "created" event.
     *
     * @param  \App\Models\ExportDetail  $exportDetail
     * @return void
     */
    public function created(ExportDetail $exportDetail)
    {
        //
    }

    /**
     * Handle the ExportDetail "updated" event.
     *
     * @param  \App\Models\ExportDetail  $exportDetail
     * @return void
     */
    public function updated(ExportDetail $exportDetail)
    {
        //
    }

    /**
     * Handle the ExportDetail "deleted" event.
     *
     * @param  \App\Models\ExportDetail  $exportDetail
     * @return void
     */
    public function deleted(ExportDetail $exportDetail)
    {
        //
    }

    /**
     * Handle the ExportDetail "restored" event.
     *
     * @param  \App\Models\ExportDetail  $exportDetail
     * @return void
     */
    public function restored(ExportDetail $exportDetail)
    {
        //
    }

    /**
     * Handle the ExportDetail "force deleted" event.
     *
     * @param  \App\Models\ExportDetail  $exportDetail
     * @return void
     */
    public function forceDeleted(ExportDetail $exportDetail)
    {
        //
    }
}
