<?php

namespace App\Observers;

use App\Enums\Business\InvoiceStatus;
use App\Enums\Statistics\TimeSeriesStatsType;
use App\Models\Bill;
use App\Models\OtherExpense;
use App\Models\TimeSeriesStatistic;
use Carbon\Carbon;

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
        $this->updateOrCreateSellsTimeSeriesStats($otherExpense);
    }

    /**
     * Handle the other expense "updated" event.
     *
     * @param  \App\Models\OtherExpense  $otherExpense
     * @return void
     */
    public function updated(OtherExpense $otherExpense)
    {
        $this->updateOrCreateSellsTimeSeriesStats($otherExpense);
    }

    /**
     * Handle the other expense "deleted" event.
     *
     * @param  \App\Models\OtherExpense  $otherExpense
     * @return void
     */
    public function deleted(OtherExpense $otherExpense)
    {
        $this->updateOrCreateSellsTimeSeriesStats($otherExpense);
        $otherExpense->payable()->delete();
    }

    /**
     * Handle the other expense "restored" event.
     *
     * @param  \App\Models\OtherExpense  $otherExpense
     * @return void
     */
    public function restored(OtherExpense $otherExpense)
    {
        $this->updateOrCreateSellsTimeSeriesStats($otherExpense);
    }

    /**
     * Handle the other expense "force deleted" event.
     *
     * @param  \App\Models\OtherExpense  $otherExpense
     * @return void
     */
    public function forceDeleted(OtherExpense $otherExpense)
    {
        $this->updateOrCreateSellsTimeSeriesStats($otherExpense);
        $otherExpense->payable()->delete();
    }

    private function updateOrCreateSellsTimeSeriesStats(OtherExpense $otherExpense)
    {
        $acceptableStatuses = [InvoiceStatus::PAID, InvoiceStatus::DUE];
        if (in_array($otherExpense->status, $acceptableStatuses)) {
            TimeSeriesStatistic::updateOrCreate([
                'tenant_id' => $otherExpense->tenant_id,
                'statistic_type' => TimeSeriesStatsType::EXPENSES,
                'date' => Carbon::parse($otherExpense->issue_date)->startOfDay()
            ], [
                'value' => $this->reCalculateSells($otherExpense, $acceptableStatuses)
            ]);
        }
    }

    private function reCalculateSells(OtherExpense $otherExpense, array $acceptableStatuses)
    {
        $startDateTime = Carbon::parse($otherExpense->issue_date)->startOfDay();
        $endDateTime = Carbon::parse($otherExpense->issue_date)->endOfDay();

        $totalExpenses = Bill::where('tenant_id', $otherExpense->tenant_id)
            ->whereIn('status', $acceptableStatuses)
            ->whereBetween('issue_date', [$startDateTime, $endDateTime])
            ->sum('total_amount');

        $totalExpenses += OtherExpense::where('tenant_id', $otherExpense->tenant_id)
            ->whereIn('status', $acceptableStatuses)
            ->whereBetween('issue_date', [$startDateTime, $endDateTime])
            ->sum('total_amount');

        return $totalExpenses;
    }
}
