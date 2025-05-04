<?php

namespace App\Observers;

use App\Models\Detail;

class DetailObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Models\Detail  $order
     * @return void
     */
    public function created(Detail $detail)
    {
        $detail->order->update(['total' => $detail->order->total()]);
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\Detail  $order
     * @return void
     */
    public function updated(Detail $detail)
    {
        $detail->order->update(['total' => $detail->order->total()]);
    }

    /**
     * Handle the Order "saved" event.
     *
     * @param  \App\Models\Detail  $order
     * @return void
     */
    // public function saved(Detail $detail)
    // {
    //     $detail->order->update(['total' => $detail->order->total()]);
    // }

    /**
     * Handle the Order "deleted" event.
     *
     * @param  \App\Models\Detail  $order
     * @return void
     */
    public function deleted(Detail $detail)
    {
        $detail->order->update(['total' => $detail->order->total()]);
    }
}
