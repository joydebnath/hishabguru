<?php

namespace App\Services\Statistics;

use App\Enums\Statistics\TimeSeriesStatsType;
use App\Enums\Status\PaymentStatus;
use App\Models\Bill;
use App\Models\Invoice;
use App\Models\OtherExpense;
use App\Models\TimeSeriesStatistic;
use Carbon\Carbon;

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
        $totalExpensesAmount = Bill::where([
            ['tenant_id', '=', $tenantId],
            ['status', '=', PaymentStatus::PAID],
        ])
            ->whereBetween('issue_date', $dateRange)
            ->sum('total_amount');

        $totalExpensesAmount += OtherExpense::where([
            ['tenant_id', '=', $tenantId],
            ['status', '=', PaymentStatus::PAID],
        ])
            ->whereBetween('issue_date', $dateRange)
            ->sum('total_amount');

        return $totalExpensesAmount;
    }

    public function getLast30DaysTotalSellsAmount($tenantId)
    {
        $start = Carbon::yesterday()->subDays(29)->startOfDay();
        $end = Carbon::yesterday()->endOfDay();

        return TimeSeriesStatistic::where([
            ['tenant_id', '=', $tenantId],
            ['statistic_type', '=', TimeSeriesStatsType::SELLS],
        ])
            ->whereBetween('date', [$start, $end])
            ->get();
    }

    public function getLast30DaysTotalExpensesAmount($tenantId)
    {
        $start = Carbon::yesterday()->subDays(29)->startOfDay();
        $end = Carbon::yesterday()->endOfDay();

        return TimeSeriesStatistic::where([
            ['tenant_id', '=', $tenantId],
            ['statistic_type', '=', TimeSeriesStatsType::EXPENSES],
        ])
            ->whereBetween('date', [$start, $end])
            ->get();
    }

    public function getLast30DaysTotalProfitsAmount($tenantId)
    {
        $start = Carbon::yesterday()->subDays(29)->startOfDay();
        $end = Carbon::yesterday()->endOfDay();

        return TimeSeriesStatistic::where([
            ['tenant_id', '=', $tenantId],
            ['statistic_type', '=', TimeSeriesStatsType::PROFITS],
        ])
            ->whereBetween('date', [$start, $end])
            ->get();
    }

    public function getLast30DaysTopFiveProductCategories($tenantId)
    {
        $start = Carbon::yesterday()->subDays(29)->startOfDay();
        $end = Carbon::yesterday()->endOfDay();

        //invoice products, group by products, get category
        return Invoice::where('tenant_id', $tenantId)
            ->isNotDraft()
            ->whereBetween('issue_date', [$start,$end])
            ->withProductId()
            ->withProductCategoryId()
            ->get(['product_category_id']);
    }
}
