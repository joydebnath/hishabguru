<?php

namespace App\Services\Statistics;

use App\Enums\Status\PaymentStatus;
use App\Models\Bill;
use App\Models\Invoice;
use App\Models\OtherExpense;
use Carbon\Carbon;

class MonthlyOverviewService
{
    public function getOverviewStatsByMonth($startDate, $tenantId): array
    {
        return [
            'incomes' => $this->getIncomesByMonth($startDate, $tenantId),
            'expenses' => $this->getExpensesByMonth($startDate, $tenantId),
            'due_bills' => $this->getTotalDueBillsByMonth($startDate, $tenantId),
            'due_invoices' => $this->getTotalDueInvoicesByMonth($startDate, $tenantId),
        ];
    }

    private function getIncomesByMonth(Carbon $month, $tenantId): float
    {
        $start = $month->startOfDay();
        $end = $month->endOfMonth()->endOfDay();

        return Invoice::where('tenant_id', $tenantId)
            ->whereBetween('issue_date', [$start, $end])
            ->isNotDraft()
            ->sum('total_amount');
    }

    private function getExpensesByMonth($month, $tenantId): float
    {
        $start = $month->startOfDay();
        $end = $month->endOfMonth()->endOfDay();

        $totalBillsAmount = Bill::where('tenant_id', $tenantId)
            ->whereBetween('issue_date', [$start, $end])
            ->isNotDraft()
            ->sum('total_amount');

        $totalOtherExpensesAmount = OtherExpense::where('tenant_id', $tenantId)
            ->whereBetween('issue_date', [$start, $end])
            ->isNotDraft()
            ->sum('total_amount');

        return $totalBillsAmount + $totalOtherExpensesAmount;
    }

    private function getTotalDueInvoicesByMonth($month, $tenantId): float
    {
        $start = $month->startOfDay();
        $end = $month->endOfMonth()->endOfDay();

        return Invoice::where([
            ['tenant_id', '=', $tenantId],
            ['status', '=', PaymentStatus::DUE],
        ])
            ->whereBetween('issue_date', [$start, $end])
            ->sum('total_amount');
    }

    private function getTotalDueBillsByMonth($month, $tenantId): float
    {
        $start = $month->startOfDay();
        $end = $month->endOfMonth()->endOfDay();

        return Bill::where([
            ['tenant_id', '=', $tenantId],
            ['status', '=', PaymentStatus::DUE],
        ])
            ->whereBetween('issue_date', [$start, $end])
            ->sum('total_amount');
    }
}
