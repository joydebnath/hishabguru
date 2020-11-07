<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\Home\DashboardRecordsService;
use App\Services\Statistics\DashboardService;
use App\Traits\Home\DashboardChartsTrait;
use App\Traits\Home\DashboardRecordsTrait;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use DashboardChartsTrait, DashboardRecordsTrait;

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
            case 'monthly-cash-flow':
                $result = $this->getLastSixMonthsCashFlow($request);
                break;
            case 'order-due-today':
                $result = $this->getOrdersDueToday($request);
                break;
            case 'top-due-invoices':
                $result = $this->getTopDueInvoices($request);
                break;
            case 'top-due-bills':
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
}
