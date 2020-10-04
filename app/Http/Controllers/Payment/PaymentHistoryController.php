<?php

namespace App\Http\Controllers\Payment;

use App\Filters\Payment\PaymentHistoryFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PaymentHistoryRequest;
use App\Http\Resources\Payment\PaymentHistoryCollection;
use App\Models\PaymentHistory;
use App\Http\Resources\Payment\PaymentHistoryResource;
use Exception;

class PaymentHistoryController extends Controller
{
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
            $this->updateTotalDue($paymentHistory->payable, $paymentHistory->amount, 'subtraction');
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
            $amount = $paymentHistory->amount;
            $payable = $paymentHistory->payable;

            $paymentHistory->delete();

            $this->updateTotalDue($payable, $amount, 'addition');

            return response(['message' => 'Payment History is deleted']);
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    // $payable = Bill || Invoice Model
    private function updateTotalDue($payable, $paidAmount, $operation): void
    {
        if ($operation === 'subtraction') {
            $paidAmount = (-1) * $paidAmount;
        }

        $payable->update([
            'total_due' => $payable->total_due + $paidAmount
        ]);
    }
}
