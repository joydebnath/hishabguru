<?php

namespace App\Services\Statistics;

use App\Enums\Status\PaymentStatus;
use App\Helpers\Helper;
use App\Models\Bill;
use App\Models\Invoice;
use App\Models\OtherExpense;
use Carbon\Carbon;

class MonthlyOverviewService
{
    public function getOverviewStatsByMonth($startDate, $tenantId): array
    {
        return [
            'incomes' => Helper::formatNumber($this->getIncomesByMonth($startDate, $tenantId)),
            'expenses' => Helper::formatNumber($this->getExpensesByMonth($startDate, $tenantId)),
            'due_bills' => Helper::formatNumber($this->getTotalDueBillsByMonth($startDate, $tenantId)),
            'due_invoices' => Helper::formatNumber($this->getTotalDueInvoicesByMonth($startDate, $tenantId)),
        ];
    }

    private function getIncomesByMonth(Carbon $month, $tenantId): float
    {
        $start = Carbon::parse($month)->startOfDay();
        $end = Carbon::parse($start)->endOfMonth()->endOfDay();
        return Invoice::where('tenant_id', $tenantId)
            ->whereBetween('issue_date', [$start, $end])
            ->isNotDraft()
            ->sum('total_amount');
    }

    private function getExpensesByMonth($month, $tenantId): float
    {
        $start = Carbon::parse($month)->startOfDay();
        $end = Carbon::parse($start)->endOfMonth()->endOfDay();

        $totalExpensesAmount = Bill::where('tenant_id', $tenantId)
            ->whereBetween('issue_date', [$start, $end])
            ->isNotDraft()
            ->sum('total_amount');

        $totalExpensesAmount += OtherExpense::where('tenant_id', $tenantId)
            ->whereBetween('issue_date', [$start, $end])
            ->isNotDraft()
            ->sum('total_amount');

        return $totalExpensesAmount;
    }

    private function getTotalDueInvoicesByMonth($month, $tenantId): float
    {
        $start = Carbon::parse($month)->startOfDay();
        $end = Carbon::parse($start)->endOfMonth()->endOfDay();

        return Invoice::where([
            ['tenant_id', '=', $tenantId],
            ['status', '=', PaymentStatus::DUE],
        ])
            ->whereBetween('issue_date', [$start, $end])
            ->sum('total_amount');
    }

    private function getTotalDueBillsByMonth($month, $tenantId): float
    {
        $start = Carbon::parse($month)->startOfDay();
        $end = Carbon::parse($start)->endOfMonth()->endOfDay();

        return Bill::where([
            ['tenant_id', '=', $tenantId],
            ['status', '=', PaymentStatus::DUE],
        ])
            ->whereBetween('issue_date', [$start, $end])
            ->sum('total_amount');
    }
}
