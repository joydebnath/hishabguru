<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use App\Http\Resources\Statistics\BillDueCollection;
use App\Services\Statistics\SupplierStatService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;

class SupplierStatsController extends Controller
{
    protected $service;

    public function __construct(SupplierStatService $service)
    {
        $this->service = $service;
    }

    public function show(Request $request, $supplierId, $type)
    {
        $result = null;
        switch ($type) {
            case 'last-twelvemonth':
                $result = $this->getLastTwelvemonthCounts($supplierId);
                break;
            case 'due-bills':
                $result = $this->getDueBills($supplierId);
                break;
            case 'paid-bills':
                $result = $this->getPaidBills($request, $supplierId);
                break;
            default:
                $result = response(['error' => 'Unsupported Statistic Type Provided'], 404);
        }
        return $result;
    }

    public function getLastTwelvemonthCounts($supplierId)
    {
        try {
            return $this->service->getLastTwelvemonthBills($supplierId);
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }

    public function getDueBills($supplierId)
    {
        try {
            return new BillDueCollection(
                $this->service->getDueBills($supplierId)
            );
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }

    public function getPaidBills(Request $request, $supplierId)
    {
        try {
            $start = Carbon::create($request->year, $request->month, 1)->startOfDay();
            $end = Carbon::create($request->year, $request->month)->endOfMonth()->endOfDay();
            return new BillDueCollection(
                $this->service->getPaidBills($supplierId, [$start, $end])
            );
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }
}
