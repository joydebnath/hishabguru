<?php

namespace App\Observers;

use App\Models\PaymentHistory;

class PaymentHistoryObserver
{
    /**
     * Handle the payment history "created" event.
     *
     * @param  \App\Models\PaymentHistory  $paymentHistory
     * @return void
     */
    public function created(PaymentHistory $paymentHistory)
    {
        //
    }

    /**
     * Handle the payment history "updated" event.
     *
     * @param  \App\Models\PaymentHistory  $paymentHistory
     * @return void
     */
    public function updated(PaymentHistory $paymentHistory)
    {
        //
    }

    /**
     * Handle the payment history "deleted" event.
     *
     * @param  \App\Models\PaymentHistory  $paymentHistory
     * @return void
     */
    public function deleted(PaymentHistory $paymentHistory)
    {
        //
    }

    /**
     * Handle the payment history "restored" event.
     *
     * @param  \App\Models\PaymentHistory  $paymentHistory
     * @return void
     */
    public function restored(PaymentHistory $paymentHistory)
    {
        //
    }

    /**
     * Handle the payment history "force deleted" event.
     *
     * @param  \App\Models\PaymentHistory  $paymentHistory
     * @return void
     */
    public function forceDeleted(PaymentHistory $paymentHistory)
    {
        //
    }
}
