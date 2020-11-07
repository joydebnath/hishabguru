<?php

namespace App\Observers;

use App\Models\OtherExpense;

class OtherExpenseObserver
{
    /**
     * Handle the other expense "created" event.
     *
     * @param  \App\Models\OtherExpense  $otherExpense
     * @return void
     */
    public function created(OtherExpense $otherExpense)
    {
        //
    }

    /**
     * Handle the other expense "updated" event.
     *
     * @param  \App\Models\OtherExpense  $otherExpense
     * @return void
     */
    public function updated(OtherExpense $otherExpense)
    {
        //
    }

    /**
     * Handle the other expense "deleted" event.
     *
     * @param  \App\Models\OtherExpense  $otherExpense
     * @return void
     */
    public function deleted(OtherExpense $otherExpense)
    {
        //
    }

    /**
     * Handle the other expense "restored" event.
     *
     * @param  \App\Models\OtherExpense  $otherExpense
     * @return void
     */
    public function restored(OtherExpense $otherExpense)
    {
        //
    }

    /**
     * Handle the other expense "force deleted" event.
     *
     * @param  \App\Models\OtherExpense  $otherExpense
     * @return void
     */
    public function forceDeleted(OtherExpense $otherExpense)
    {
        //
    }
}
