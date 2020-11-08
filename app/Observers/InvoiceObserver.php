<?php

namespace App\Observers;

use App\Enums\Business\InvoiceStatus;
use App\Enums\Payment\CreditRecordType;
use App\Enums\Statistics\TimeSeriesStatsType;
use App\Models\ContactCreditRecord;
use App\Models\CopyReference;
use App\Models\Invoice;
use App\Models\TimeSeriesStatistic;
use Carbon\Carbon;

class InvoiceObserver
{
    /**
     * Handle the invoice "created" event.
     *
     * @param \App\Models\Invoice $invoice
     * @return void
     */
    public function created(Invoice $invoice)
    {
        $this->updateOrCreateSellsTimeSeriesStats($invoice);
        $this->updateOrCreateProfitTimeSeriesStats($invoice);
        $this->updateContactCreditRecord($invoice);
    }

    /**
     * Handle the invoice "updated" event.
     *
     * @param \App\Models\Invoice $invoice
     * @return void
     */
    public function updated(Invoice $invoice)
    {
        $this->updateOrCreateSellsTimeSeriesStats($invoice);
        $this->updateOrCreateProfitTimeSeriesStats($invoice);
    }

    /**
     * Handle the invoice "deleted" event.
     *
     * @param \App\Models\Invoice $invoice
     * @return void
     */
    public function deleted(Invoice $invoice)
    {
        $this->updateOrCreateSellsTimeSeriesStats($invoice);
        $this->updateOrCreateProfitTimeSeriesStats($invoice);

        CopyReference::where('copy_to_id', $invoice->id)->where('copy_to_type', 'invoices')->delete();
        $invoice->payable()->delete();
    }

    /**
     * Handle the invoice "restored" event.
     *
     * @param \App\Models\Invoice $invoice
     * @return void
     */
    public function restored(Invoice $invoice)
    {
        $this->updateOrCreateSellsTimeSeriesStats($invoice);
        $this->updateOrCreateProfitTimeSeriesStats($invoice);
    }

    /**
     * Handle the invoice "force deleted" event.
     *
     * @param \App\Models\Invoice $invoice
     * @return void
     */
    public function forceDeleted(Invoice $invoice)
    {
        $this->updateOrCreateSellsTimeSeriesStats($invoice);
        $this->updateOrCreateProfitTimeSeriesStats($invoice);

        CopyReference::where('copy_to_id', $invoice->id)->where('copy_to_type', 'invoices')->delete();
        $invoice->payable()->delete();
    }

    private function updateOrCreateSellsTimeSeriesStats(Invoice $invoice)
    {
        $acceptableStatuses = [InvoiceStatus::PAID, InvoiceStatus::DUE];
        if (in_array($invoice->status, $acceptableStatuses)) {
            TimeSeriesStatistic::updateOrCreate([
                'tenant_id' => $invoice->tenant_id,
                'statistic_type' => TimeSeriesStatsType::SELLS,
                'date' => Carbon::parse($invoice->issue_date)->startOfDay()
            ], [
                'value' => $this->reCalculateSells($invoice, $acceptableStatuses)
            ]);
        }
    }

    private function reCalculateSells(Invoice $invoice, array $acceptableStatuses)
    {
        $startDateTime = Carbon::parse($invoice->issue_date)->startOfDay();
        $endDateTime = Carbon::parse($invoice->issue_date)->endOfDay();

        return Invoice::where('tenant_id', $invoice->tenant_id)
            ->whereIn('status', $acceptableStatuses)
            ->whereBetween('issue_date', [$startDateTime, $endDateTime])
            ->sum('total_amount');
    }

    private function updateOrCreateProfitTimeSeriesStats(Invoice $invoice)
    {
        $acceptableStatuses = [InvoiceStatus::PAID, InvoiceStatus::DUE];
        if (in_array($invoice->status, $acceptableStatuses)) {
            TimeSeriesStatistic::updateOrCreate([
                'tenant_id' => $invoice->tenant_id,
                'statistic_type' => TimeSeriesStatsType::PROFITS,
                'date' => Carbon::parse($invoice->issue_date)->startOfDay()
            ], [
                'value' => $this->reCalculateProfit($invoice, $acceptableStatuses)
            ]);
        }
    }

    private function reCalculateProfit(Invoice $invoice, array $acceptableStatuses)
    {
        $startDateTime = Carbon::parse($invoice->issue_date)->startOfDay();
        $endDateTime = Carbon::parse($invoice->issue_date)->endOfDay();

        return Invoice::where('tenant_id', $invoice->tenant_id)
            ->whereIn('status', $acceptableStatuses)
            ->whereBetween('issue_date', [$startDateTime, $endDateTime])
            ->sum('total_profit');
    }
}
