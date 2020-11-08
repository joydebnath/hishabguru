<?php

namespace App\Http\Controllers\Payment;

use App\Enums\Status\PaymentStatus;
use App\Filters\Payment\PaymentHistoryFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PaymentHistoryRequest;
use App\Http\Resources\Payment\PaymentHistoryCollection;
use App\Models\Bill;
use App\Models\Invoice;
use App\Models\OtherExpense;
use App\Models\PaymentHistory;
use App\Http\Resources\Payment\PaymentHistoryResource;
use App\Services\Payment\CreditRecordService;
use Exception;

class PaymentHistoryController extends Controller
{
    protected $creditRecordService;

    public function __construct(CreditRecordService $creditRecordService)
    {
        $this->creditRecordService = $creditRecordService;
    }

    public function index(PaymentHistoryFilter $filters)
    {
        try {
            return new PaymentHistoryCollection(PaymentHistory::filter($filters)->get());
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function store(PaymentHistoryRequest $request)
    {
        try {
            $paymentHistory = PaymentHistory::create($request->validated());
            $this->updateTotalDue($paymentHistory->payable, $paymentHistory->payable->payable);
            return new PaymentHistoryResource($paymentHistory->fresh('payable'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function show(PaymentHistory $paymentHistory)
    {
        try {
            return new PaymentHistoryResource($paymentHistory->load('payable'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function update(PaymentHistoryRequest $request, PaymentHistory $paymentHistory)
    {
        abort(404, 'No implementation found');
    }

    public function destroy(PaymentHistory $paymentHistory)
    {
        try {
            $payable = $paymentHistory->payable;

            $paymentHistory->delete();

            $this->updateTotalDue($payable, $payable->payable);

            return response(['message' => 'Payment History is deleted']);
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    // $payable = Bill || Invoice || OtherExpense Model
    private function updateTotalDue($payable, $paymentHistories): void
    {
        $totalPaid = $paymentHistories ? collect($paymentHistories)->sum('amount') : 0;
        $payable->update([
            'total_due' => abs($payable->total_amount - $totalPaid),
            'status' => $totalPaid >= $payable->total_amount ? PaymentStatus::PAID : PaymentStatus::DUE
        ]);

        $this->updateContactCreditRecord($payable);
    }

    private function updateContactCreditRecord($payable): bool
    {
        $className = get_class($payable);
        if ($className === Invoice::class) {
            $this->creditRecordService->updateClientCreditRecord($payable);
            return true;
        } elseif ($className === Bill::class) {
            $this->creditRecordService->updateSupplierCreditRecord($payable);
            return true;
        }
        return false;
    }
}
