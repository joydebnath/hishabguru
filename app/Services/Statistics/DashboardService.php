<?php

namespace App\Services\Statistics;

use App\Enums\Status\PaymentStatus;
use App\Models\Bill;
use App\Models\Invoice;
use App\Models\OtherExpense;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getOverviewStatsByMonth($startDate, $tenantId): array
    {
        return (new MonthlyOverviewService())->getOverviewStatsByMonth($startDate, $tenantId);
    }

    public function getLastSixMonthsCashFlow($tenantId)
    {
        $months = [];
        $cashInAmount = [];
        $cashOutAmount = [];

        for ($i = 0; $i < 6; $i++) {
            $start = Carbon::today()->subMonths($i)->startOfMonth()->startOfDay();
            $end = Carbon::today()->subMonths($i)->endOfMonth()->endOfDay();

            array_push($months, $start->format('M'));
            array_push($cashInAmount, $this->getInvoicesSum($tenantId, [$start, $end]));
            array_push($cashOutAmount, $this->getExpensesSum($tenantId, [$start, $end]));
        }

        return [
            'months' => $months,
            'cash_in_amount' => $cashInAmount,
            'cash_out_amount' => $cashOutAmount,
        ];
    }

    private function getInvoicesSum($tenantId, $dateRange)
    {
        return Invoice::where([
            ['tenant_id', '=', $tenantId],
            ['status', '=', PaymentStatus::PAID],
        ])
            ->whereBetween('issue_date', $dateRange)
            ->sum('total_amount');
    }

    private function getExpensesSum($tenantId, $dateRange)
    {
        $totalBillAmount = Bill::where([
            ['tenant_id', '=', $tenantId],
            ['status', '=', PaymentStatus::PAID],
        ])
            ->whereBetween('issue_date', $dateRange)
            ->sum('total_amount');

        $totalOtherExpensesAmount = OtherExpense::where([
            ['tenant_id', '=', $tenantId],
            ['status', '=', PaymentStatus::PAID],
        ])
            ->whereBetween('issue_date', $dateRange)
            ->sum('total_amount');

        return $totalBillAmount + $totalOtherExpensesAmount;
    }

    public function getLast30DaysTotalSellsAmount($tenantId)
    {
        $start = Carbon::today()->subDays(29)->startOfDay();
        $end = Carbon::today()->endOfDay();

        return Invoice::where('tenant_id', $tenantId)
            ->isNotDraft()
            ->whereBetween('issue_date', [$start, $end])
            ->addSelect(DB::raw('issue_date as issued_on'))
            ->get();
    }

    public function getLast30DaysTotalExpensesAmount($tenantId)
    {
        $start = Carbon::today()->subDays(29)->startOfDay();
        $end = Carbon::today()->endOfDay();

        $totalBillAmount = Bill::where('tenant_id', $tenantId)
            ->isNotDraft()
            ->whereBetween('issue_date', [$start, $end])
            ->addSelect(DB::raw('issue_date as issued_on'))
            ->get();

        $totalOtherExpensesAmount = OtherExpense::where('tenant_id', $tenantId)
            ->isNotDraft()
            ->whereBetween('issue_date', [$start, $end])
            ->addSelect(DB::raw('issue_date as issued_on'))
            ->get();
        return 0;
    }

    public function getLast30DaysTotalProfitsAmount($tenantId)
    {
        $start = Carbon::today()->subDays(29)->startOfDay();
        $end = Carbon::today()->endOfDay();

        //(product price * quantity) - product sub_total
        return 0;
    }

    public function getLast30DaysTopFiveProductCategories($tenantId)
    {
        $start = Carbon::today()->subDays(29)->startOfDay();
        $end = Carbon::today()->endOfDay();

        //invoice products, group by products, get category
        return 0;
    }
}
