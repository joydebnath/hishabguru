<?php

namespace App\Traits\Home;

use App\Http\Resources\Statistics\BillDueCollection;
use App\Http\Resources\Statistics\InvoiceDueCollection;
use App\Http\Resources\Statistics\OrderDueCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;

trait DashboardRecordsTrait
{
    public function getOrdersDueToday(Request $request)
    {
        try {
            return new OrderDueCollection(
                $this->recordsService->getOrdersDueByDate(Carbon::today(), $request->tenant_id)
            );
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }

    public function getTopDueInvoices(Request $request)
    {
        try {
            return new InvoiceDueCollection(
                $this->recordsService->getTopTenDueInvoices($request->tenant_id)
            );
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }

    public function getTopDueBills(Request $request)
    {
        try {
            return new BillDueCollection(
                $this->recordsService->getTopTenDueBills($request->tenant_id)
            );
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }
}
