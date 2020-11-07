<?php

namespace App\Providers;

use App\Models\Bill;
use App\Models\Invoice;
use App\Models\OtherExpense;
use App\Models\PaymentHistory;
use App\Observers\BillObserver;
use App\Observers\InvoiceObserver;
use App\Observers\OtherExpenseObserver;
use App\Observers\PaymentHistoryObserver;
use Illuminate\Support\ServiceProvider;

class ModelObserverProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Invoice::observe(InvoiceObserver::class);
        Bill::observe(BillObserver::class);
        OtherExpense::observe(OtherExpenseObserver::class);
        PaymentHistory::observe(PaymentHistoryObserver::class);
    }
}
