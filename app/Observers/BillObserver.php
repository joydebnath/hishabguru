<?php

namespace App\Observers;

use App\Models\Bill;

class BillObserver
{
    /**
     * Handle the bill "created" event.
     *
     * @param  \App\Models\Bill  $bill
     * @return void
     */
    public function created(Bill $bill)
    {
        //TODO
        //Create or Update Record on TimeSeriesStatistics Table
    }

    /**
     * Handle the bill "updated" event.
     *
     * @param  \App\Models\Bill  $bill
     * @return void
     */
    public function updated(Bill $bill)
    {
        //Create or Update Record on TimeSeriesStatistics Table
    }

    /**
     * Handle the bill "deleted" event.
     *
     * @param  \App\Models\Bill  $bill
     * @return void
     */
    public function deleted(Bill $bill)
    {
        //Update Record on TimeSeriesStatistics Table
    }

    /**
     * Handle the bill "restored" event.
     *
     * @param  \App\Models\Bill  $bill
     * @return void
     */
    public function restored(Bill $bill)
    {
        //
    }

    /**
     * Handle the bill "force deleted" event.
     *
     * @param  \App\Models\Bill  $bill
     * @return void
     */
    public function forceDeleted(Bill $bill)
    {
        //
    }
}
