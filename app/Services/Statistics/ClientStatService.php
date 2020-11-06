<?php

namespace App\Services\Statistics;

use App\Enums\Status\PaymentStatus;
use App\Models\Invoice;
use Carbon\Carbon;

class ClientStatService
{
    public function getLastTwelvemonthInvoices($clientId)
    {
        $months = [];
        $amounts = [];

        for ($i = 0; $i < 12; $i++) {
            $start = Carbon::today()->subMonths($i)->startOfMonth()->startOfDay();
            $end = Carbon::today()->subMonths($i)->endOfMonth()->endOfDay();
            array_push($months, $start->format('M'));
            array_push($amounts, $this->getInvoicesSum($clientId, [$start, $end]));
        }

        return [
            'months' => $months,
            'invoice_amounts' => $amounts
        ];
    }

    private function getInvoicesSum($clientId, $dateRange)
    {
        return Invoice::where('contact_id', $clientId)
            ->whereBetween('issue_date', $dateRange)
            ->notDrafts()
            ->sum('total_amount');
    }

    public function getDueInvoices($clientId)
    {
        return Invoice::where([
            ['contact_id', '=', $clientId],
            ['status', '=', PaymentStatus::DUE]
        ])->get();
    }

    public function getPaidInvoices($clientId, $dateRange)
    {
        return Invoice::where([
            ['contact_id', '=', $clientId],
            ['status', '=', PaymentStatus::PAID]
        ])
            ->whereBetween('issue_date', $dateRange)
            ->get();
    }
}
