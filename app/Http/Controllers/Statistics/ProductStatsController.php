<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use App\Http\Resources\Statistics\ProductPurchaseCollection;
use App\Http\Resources\Statistics\ProductSellCollection;
use App\Services\Statistics\ProductStatService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;

class ProductStatsController extends Controller
{
    protected $service;

    public function __construct(ProductStatService $service)
    {
        $this->service = $service;
    }

    public function show(Request $request, $productId, $type)
    {
        $result = null;
        switch ($type){
            case 'last-twelvemonth':
                $result = $this->getLastTwelvemonthCounts($productId);
                break;
            case 'sell-records':
                $result = $this->getSellRecords($request, $productId);
                break;
            case 'purchase-records':
                $result = $this->getPurchaseRecords($request, $productId);
                break;
            default:
                $result = response(['error' => 'Unsupported Statistic Type Provided'], 404);
        }
        return $result;
    }

    public function getLastTwelvemonthCounts($productId)
    {
        try {
            return $this->service->getLastTwelvemonthCounts($productId);
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }

    public function getSellRecords(Request $request, $productId)
    {
        try {
            $start = Carbon::create($request->year, $request->month, 1)->startOfDay();
            $end = Carbon::create($request->year, $request->month)->endOfMonth()->endOfDay();
            return new ProductSellCollection(
                $this->service->getProductSells($productId, [$start, $end])
            );
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }

    public function getPurchaseRecords(Request $request, $productId)
    {
        try {
            $start = Carbon::create($request->year, $request->month, 1)->startOfDay();
            $end = Carbon::create($request->year, $request->month)->endOfMonth()->endOfDay();
            return new ProductPurchaseCollection(
                $this->service->getProductPurchases($productId, [$start, $end])
            );
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }
}
