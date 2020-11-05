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
use Illuminate\Support\Str;

class ReferenceNumberGenerateController extends Controller
{
    public function generate($type)
    {
        try {
            $currentYearMonth = Carbon::today()->format('yn');
            $newNumber = $this->getPrefix($type) . '-' . $currentYearMonth . strtoupper(Str::random(4));

            return response(['data' => ['number' => $newNumber]], 200);
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
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
