<?php

namespace App\Services\Home;

use App\Enums\Status\PaymentStatus;
use App\Http\Resources\Statistics\BillDueCollection;
use App\Http\Resources\Statistics\InvoiceDueCollection;
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
            ])
            ->with('contact')
            ->get();
    }

    public function getTopTenDueInvoices($tenantId)
    {
        return [
            'data' => new InvoiceDueCollection(
                Invoice::where([
                    ['tenant_id', '=', $tenantId],
                    ['status', '=', PaymentStatus::DUE]
                ])
                    ->orderBy('total_due', 'desc')
                    ->limit(10)
                    ->with('contact')
                    ->get()
            ),
            'total_due' => number_format(Invoice::where([
                ['tenant_id', '=', $tenantId],
                ['status', '=', PaymentStatus::DUE]
            ])
                ->sum('total_due'), 2)
        ];
    }

    public function getTopTenDueBills($tenantId)
    {
        return [
            'data' => new BillDueCollection(

                Bill::where([
                    ['tenant_id', '=', $tenantId],
                    ['status', '=', PaymentStatus::DUE]
                ])
                    ->orderBy('total_due', 'desc')
                    ->with('contact')
                    ->limit(10)
                    ->get()),
            'total_due' => number_format(Bill::where([
                ['tenant_id', '=', $tenantId],
                ['status', '=', PaymentStatus::DUE]
            ])
                ->sum('total_due'), 2)
        ];
    }
}
