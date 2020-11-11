<?php

namespace App\Services\Statistics;

use App\Enums\Statistics\TimeSeriesStatsType;
use App\Enums\Status\PaymentStatus;
use App\Models\Bill;
use App\Models\Invoice;
use App\Models\OtherExpense;
use App\Models\TimeSeriesStatistic;
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

        $series = TimeSeriesStatistic::where([
            ['tenant_id', '=', $tenantId],
            ['statistic_type', '=', TimeSeriesStatsType::SELLS],
        ])
            ->whereBetween('date', [$start, $end])
            ->select('date', 'value')
            ->orderBy('date')
            ->get();

        return $this->generateTimeSeries($start, 30, $series);
    }

    public function getLast30DaysTotalExpensesAmount($tenantId)
    {
        $start = Carbon::yesterday()->subDays(29)->startOfDay();
        $end = Carbon::yesterday()->endOfDay();

        $series = TimeSeriesStatistic::where([
            ['tenant_id', '=', $tenantId],
            ['statistic_type', '=', TimeSeriesStatsType::EXPENSES],
        ])
            ->whereBetween('date', [$start, $end])
            ->select('date', 'value')
            ->orderBy('date')
            ->get();

        return $this->generateTimeSeries($start, 30, $series);
    }

    public function getLast30DaysTotalProfitsAmount($tenantId)
    {
        $start = Carbon::yesterday()->subDays(29)->startOfDay();
        $end = Carbon::yesterday()->endOfDay();

        $series = TimeSeriesStatistic::where([
            ['tenant_id', '=', $tenantId],
            ['statistic_type', '=', TimeSeriesStatsType::PROFITS],
        ])
            ->whereBetween('date', [$start, $end])
            ->select('date', 'value')
            ->orderBy('date')
            ->get();

        return $this->generateTimeSeries($start, 30, $series);
    }

    public function getLast30DaysTopFiveProductCategories($tenantId)
    {
        $start = Carbon::yesterday()->subDays(29)->startOfDay();
        $end = Carbon::yesterday()->endOfDay();

        $invoices = Invoice::select('id')
            ->where('tenant_id', $tenantId)
            ->isNotDraft()
            ->whereBetween('issue_date', [$start, $end])
            ->withProductCategoryId()
            ->get()
            ->groupBy('product_category_name');

        return collect($invoices)->map(function ($group, $index) {
            return ['name' => $index, 'count' => collect($group)->count()];
        })->values()->sortByDesc('count')->values()->take(5);
    }

    private function generateTimeSeries(Carbon $startDate, $days, $filledSeries)
    {
        $timeSeries = [];
        for ($i = 0; $i < $days; $i++) {
            $date = $startDate->addDays(1)->format('Y-m-d');
            $timeSeries[$date] = '0';
        }
        return $this->combineTimeSeries($filledSeries, $timeSeries);
    }

    private function combineTimeSeries($filledSeries, $emptySeries)
    {
        foreach ($filledSeries as $series) {
            $emptySeries[Carbon::parse($series['date'])->format('Y-m-d')] = $series['value'];
        }
        return [
            'timeline' => array_keys($emptySeries),
            'data' => array_values($emptySeries),
        ];
    }
}
