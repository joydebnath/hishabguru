<?php

namespace App\Services\Statistics;

use App\Models\Product;
use Carbon\Carbon;

class ProductStatService
{
    public function getLastTwelvemonthCounts($productId)
    {
        $months = [];
        $counts = [];

        for ($i = 0; $i < 12; $i++) {
            $start = Carbon::today()->subMonths($i)->startOfMonth()->startOfDay();
            $end = Carbon::today()->subMonths($i)->endOfMonth()->endOfDay();
            array_push($months, $start->format('M'));
            array_push($counts, $this->getProductSellCount($productId, [$start, $end]));
        }

        return [
            'months' => $months,
            'sell_counts' => $counts
        ];
    }

    private function getProductSellCount($productId, $dateRange)
    {
        return Product::find($productId)->invoices()->whereBetween('issue_date', $dateRange)->count();
    }

    public function getProductSells($productId, $dateRange)
    {
        return Product::find($productId)->invoices()->whereBetween('issue_date', $dateRange)->get();
    }

    public function getProductPurchases($productId, $dateRange)
    {
        return Product::find($productId)->bills()->whereBetween('issue_date', $dateRange)->get();
    }
}
