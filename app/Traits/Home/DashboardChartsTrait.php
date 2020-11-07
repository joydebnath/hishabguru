<?php

namespace App\Traits\Home;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;

trait DashboardChartsTrait
{
    public function getCurrentMonthStats(Request $request)
    {
        try {
            return $this->statsService->getOverviewStatsByMonth(Carbon::today()->startOfMonth(), $request->tenant_id);
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }

    public function getLastSixMonthsCashFlow(Request $request)
    {
        try {
            return $this->statsService->getLastSixMonthsCashFlow($request->tenant_id);
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }

    public function getLastThirtyDaysSells(Request $request)
    {
        try {
            return $this->statsService->getLast30DaysTotalSellsAmount($request->tenant_id);
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }

    public function getLastThirtyDaysExpenses(Request $request)
    {
        try {
            return $this->statsService->getLast30DaysTotalExpensesAmount($request->tenant_id);
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }

    public function getLastThirtyDaysProfits(Request $request)
    {
        try {
            return $this->statsService->getLast30DaysTotalProfitsAmount($request->tenant_id);
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }

    public function getLastThirtyDaysTopCategories(Request $request)
    {
        try {
            return $this->statsService->getLast30DaysTopFiveProductCategories($request->tenant_id);
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }
}
