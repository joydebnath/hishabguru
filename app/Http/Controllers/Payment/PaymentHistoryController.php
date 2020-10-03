<?php

namespace App\Http\Controllers\Payment;

use App\Filters\Payment\PaymentHistoryFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PaymentHistoryRequest;
use App\Http\Resources\Payment\PaymentHistoryCollection;
use App\Models\PaymentHistory;
use App\Http\Resources\Payment\PaymentHistory as PaymentHistoryResource;
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
            return new PaymentHistoryResource($paymentHistory->load('payable'));
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
            $paymentHistory->delete();
            return response(['message' => 'Payment History is deleted']);
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }
}
