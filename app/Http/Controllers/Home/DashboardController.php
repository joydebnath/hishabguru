<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\Statistics\BillDueCollection;
use App\Http\Resources\Statistics\InvoiceDueCollection;
use App\Services\Home\DashboardRecordsService;
use App\Services\Statistics\DashboardService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;

class DashboardController extends Controller
{
    protected $statsService, $recordsService;

    public function __construct(DashboardService $statsService, DashboardRecordsService $recordsService)
    {
        $this->statsService = $statsService;
        $this->recordsService = $recordsService;
    }

    public function show(Request $request, $type)
    {
        $result = null;
        switch ($type) {
            case 'current-month-statistics':
                $result = $this->getCurrentMonthStats($request);
                break;
            case 'order-due-today':
                $result = $this->getOrdersDueToday($request);
                break;
            case 'top-dues':
                $result = $this->getTopDueInvoices($request);
                break;
            case 'top-bills':
                $result = $this->getTopDueBills($request);
                break;
            case 'last-30days-sells':
                $result = $this->getLastThirtyDaysSells($request);
                break;
            case 'last-30days-expenses':
                $result = $this->getLastThirtyDaysExpenses($request);
                break;
            case 'last-30days-profits':
                $result = $this->getLastThirtyDaysProfits($request);
                break;
            case 'last-30days-categories':
                $result = $this->getLastThirtyDaysTopCategories($request);
                break;
            default:
                $result = response(['error' => 'Unsupported Statistic Type Provided'], 404);
        }
        return $result;
    }

    public function getCurrentMonthStats(Request $request)
    {
        try {
            return $this->statsService->getOverviewStatsByMonth(Carbon::today()->startOfMonth(), $request->tenant_id);
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }

    public function getOrdersDueToday(Request $request)
    {
        try {
            return $this->recordsService->getOrdersDueByDate(Carbon::today(), $request->tenant_id);
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }

    public function getTopDueInvoices(Request $request)
    {
        try {
            return new InvoiceDueCollection($this->recordsService->getTopTenDueInvoices($request->tenant_id));
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }

    public function getTopDueBills(Request $request)
    {
        try {
            return new BillDueCollection($this->recordsService->getTopTenDueBills($request->tenant_id));
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }

    public function getLastThirtyDaysSells(Request $request)
    {
        try {
            return new BillDueCollection($this->statsService->getLast30DaysTotalSellsAmount($request->tenant_id));
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }

    public function getLastThirtyDaysExpenses(Request $request)
    {
        try {
            return new BillDueCollection($this->statsService->getLast30DaysTotalExpensesAmount($request->tenant_id));
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }

    public function getLastThirtyDaysProfits(Request $request)
    {
        try {
            return new BillDueCollection($this->statsService->getLast30DaysTotalProfitsAmount($request->tenant_id));
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }

    public function getLastThirtyDaysTopCategories(Request $request)
    {
        try {
            return new BillDueCollection($this->statsService->getLast30DaysTopFiveProductCategories($request->tenant_id));
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }
}
