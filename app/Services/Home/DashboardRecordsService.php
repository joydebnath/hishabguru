<?php

namespace App\Services\Home;

use App\Enums\Status\PaymentStatus;
use App\Models\Bill;
use App\Models\Invoice;
use App\Models\Order;
use Carbon\Carbon;

class DashboardRecordsService
{
    public function getOrdersDueByDate(Carbon $date, $tenantId)
    {
        return Order::where([
            ['tenant_id', '=', $tenantId],
            ['status', '<>', 'draft']
        ])
            ->whereBetween('delivery_date', [
                $date->startOfDay(),
                $date->endOfDay()
            ])->get();
    }

    public function getTopTenDueInvoices($tenantId)
    {
        return Invoice::where([
            ['tenant_id', '=', $tenantId],
            ['status', '=', PaymentStatus::DUE]
        ])
            ->orderBy('total_due', 'desc')
            ->limit(10)
            ->get();
    }

    public function getTopTenDueBills($tenantId)
    {
        return Bill::where([
            ['tenant_id', '=', $tenantId],
            ['status', '=', PaymentStatus::DUE]
        ])
            ->orderBy('total_due', 'desc')
            ->limit(10)
            ->get();
    }
}
