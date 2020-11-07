<?php

namespace App\Services\Statistics;

use App\Enums\Status\PaymentStatus;
use App\Models\Bill;
use Carbon\Carbon;

class SupplierStatService
{
    public function getLastTwelvemonthBills($supplierId)
    {
        $months = [];
        $amounts = [];

        for ($i = 0; $i < 12; $i++) {
            $start = Carbon::today()->subMonths($i)->startOfMonth()->startOfDay();
            $end = Carbon::today()->subMonths($i)->endOfMonth()->endOfDay();
            array_push($months, $start->format('M'));
            array_push($amounts, $this->getBillsSum($supplierId, [$start, $end]));
        }

        return [
            'months' => $months,
            'bill_amounts' => $amounts
        ];
    }

    private function getBillsSum($supplierId, $dateRange)
    {
        return Bill::where('contact_id', $supplierId)
            ->whereBetween('issue_date', $dateRange)
            ->isNotDraft()
            ->sum('total_amount');
    }

    public function getDueBills($supplierId)
    {
        return Bill::where([
            ['contact_id', '=', $supplierId],
            ['status', '=', PaymentStatus::DUE]
        ])->get();
    }

    public function getPaidBills($supplierId, $dateRange)
    {
        return Bill::where([
            ['contact_id', '=', $supplierId],
            ['status', '=', PaymentStatus::PAID]
        ])
            ->whereBetween('issue_date', $dateRange)
            ->get();
    }
}
