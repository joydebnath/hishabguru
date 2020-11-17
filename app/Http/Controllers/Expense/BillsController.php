<?php

namespace App\Http\Controllers\Expense;

use App\Enums\Status\PaymentStatus;
use App\Filters\Expense\BillFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Expense\BillRequest;
use App\Http\Resources\Expense\BillCollection;
use App\Http\Resources\Expense\BillFullResource;
use App\Models\Bill;
use App\Http\Resources\Expense\Bill as BillResource;
use App\Services\Expense\BillService;
use App\Services\Payment\CreditRecordService;
use Exception;

class BillsController extends Controller
{
    protected $service, $creditRecordService;

    public function __construct(BillService $service)
    {
        $this->service = $service;
    }

    public function index(BillFilter $filters)
    {
        try {
            return new BillCollection(
                Bill::filter($filters)->paginate()
            );
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function store(BillRequest $request)
    {
        try {
            $bill = $this->service->create($request);

            return new BillResource($bill->load('contact'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }


    public function show(Bill $bill)
    {
        try {
            return new BillFullResource($bill->load('contact', 'products'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function update(BillRequest $request, Bill $bill)
    {
        try {
            $this->service->update($request, $bill);

            return new BillResource($bill->load('contact'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function destroy(Bill $bill)
    {
        try {
            $bill->delete(); // This triggers BillObserver
            return response(['message' => 'Bill is deleted']);
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }
}
