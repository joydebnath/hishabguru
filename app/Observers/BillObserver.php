<?php

namespace App\Observers;

use App\Enums\Business\InvoiceStatus;
use App\Enums\Payment\CreditRecordType;
use App\Enums\Statistics\TimeSeriesStatsType;
use App\Models\Bill;
use App\Models\ContactCreditRecord;
use App\Models\CopyReference;
use App\Models\OtherExpense;
use App\Models\TimeSeriesStatistic;
use Carbon\Carbon;

class BillObserver
{
    /**
     * Handle the bill "created" event.
     *
     * @param \App\Models\Bill $bill
     * @return void
     */
    public function created(Bill $bill)
    {
        $this->updateOrCreateSellsTimeSeriesStats($bill);
    }

    /**
     * Handle the bill "updated" event.
     *
     * @param \App\Models\Bill $bill
     * @return void
     */
    public function updated(Bill $bill)
    {
        $this->updateOrCreateSellsTimeSeriesStats($bill);
    }

    /**
     * Handle the bill "deleted" event.
     *
     * @param \App\Models\Bill $bill
     * @return void
     */
    public function deleted(Bill $bill)
    {
        $this->updateOrCreateSellsTimeSeriesStats($bill);

        CopyReference::where('copy_to_id', $bill->id)->where('copy_to_type', 'bills')->delete();
        $bill->payable()->delete();
    }

    /**
     * Handle the bill "restored" event.
     *
     * @param \App\Models\Bill $bill
     * @return void
     */
    public function restored(Bill $bill)
    {
        $this->updateOrCreateSellsTimeSeriesStats($bill);
    }

    /**
     * Handle the bill "force deleted" event.
     *
     * @param \App\Models\Bill $bill
     * @return void
     */
    public function forceDeleted(Bill $bill)
    {
        $this->updateOrCreateSellsTimeSeriesStats($bill);

        CopyReference::where('copy_to_id', $bill->id)->where('copy_to_type', 'bills')->delete();
        $bill->payable()->delete();
    }

    private function updateOrCreateSellsTimeSeriesStats(Bill $bill)
    {
        $acceptableStatuses = [InvoiceStatus::PAID, InvoiceStatus::DUE];
        if (in_array($bill->status, $acceptableStatuses)) {
            TimeSeriesStatistic::updateOrCreate([
                'tenant_id' => $bill->tenant_id,
                'statistic_type' => TimeSeriesStatsType::EXPENSES,
                'date' => Carbon::parse($bill->issue_date)->startOfDay()
            ], [
                'value' => $this->reCalculateSells($bill, $acceptableStatuses)
            ]);
        }
    }

    private function reCalculateSells(Bill $bill, array $acceptableStatuses)
    {
        $startDateTime = Carbon::parse($bill->issue_date)->startOfDay();
        $endDateTime = Carbon::parse($bill->issue_date)->endOfDay();

        $totalExpenses = Bill::where('tenant_id', $bill->tenant_id)
            ->whereIn('status', $acceptableStatuses)
            ->whereBetween('issue_date', [$startDateTime, $endDateTime])
            ->sum('total_amount');

        $totalExpenses += OtherExpense::where('tenant_id', $bill->tenant_id)
            ->whereIn('status', $acceptableStatuses)
            ->whereBetween('issue_date', [$startDateTime, $endDateTime])
            ->sum('total_amount');

        return $totalExpenses;
    }
}
