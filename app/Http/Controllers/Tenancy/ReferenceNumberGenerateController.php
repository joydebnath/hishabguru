<?php

namespace App\Http\Controllers\Tenancy;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OtherExpense;
use App\Models\Purchase;
use App\Models\Quotation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Exception;

class ReferenceNumberGenerateController extends Controller
{
    public function generate($type)
    {
        try {
            $currentMonth = Carbon::today()->month;
            $currentYear = Carbon::today()->year;

            $count = $this->getModel($type)
                ->where('tenant_id', request()->tenant_id)
                ->whereBetween('created_at', [
                    Carbon::today()->startOfMonth()->startOfDay(),
                    Carbon::today()->endOfMonth()->EndOfDay()
                ])
                ->count();
            $newNumber = $this->getPrefix($type) . '-' . $currentYear . $currentMonth . ($count + 1);
            return response(['data' => ['number' => $newNumber]], 200);
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }

    private function getModel($type): Model
    {
        if ($type === 'quotations') {
            return new Quotation;
        } elseif ($type === 'orders') {
            return new Order;
        } elseif ($type === 'purchases') {
            return new Purchase;
        } elseif ($type === 'invoices') {
            return new Invoice;
        } elseif ($type === 'bills') {
            return new Bill;
        } elseif ($type === 'other-expenses') {
            return new OtherExpense;
        }
        throw new Exception('Unsupported model name');
    }

    private function getPrefix($type): string
    {
        if ($type === 'quotations') {
            return 'QU';
        } elseif ($type === 'orders') {
            return 'ORD';
        } elseif ($type === 'purchases') {
            return 'PO';
        } elseif ($type === 'invoices') {
            return 'INV';
        } elseif ($type === 'bills') {
            return 'BIL';
        } elseif ($type === 'other-expenses') {
            return 'OE';
        }
        throw new Exception('Unsupported model name');
    }
}
