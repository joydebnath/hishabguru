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
use App\Services\Payment\CreditRecordService;
use Exception;

class BillsController extends Controller
{
    protected $creditRecordService;

    public function __construct(CreditRecordService $creditRecordService)
    {
        $this->creditRecordService = $creditRecordService;
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
            $storable = $this->getFillable($request);
            if ($request->status !== 'draft') {
                $storable['total_due'] = $request->total_amount;
            }
            $bill = Bill::create($storable);

            foreach ($request->products as $product) {
                $bill->products()->attach($product['id'], [
                    'quantity' => intval($product['quantity']),
                    'buying_unit_cost' => doubleval($product['buying_unit_cost']),
                    'description' => $product['description'] ? $product['description'] : null,
                    'tax_rate' => doubleval($product['tax_rate']),
                    'total' => doubleval($product['total_buying_cost']),
                ]);
            }

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
            $storable = $this->getFillable($request);
            $bill->update($storable);

            $syncable = [];
            foreach ($request->products as $product) {
                $syncable[$product['id']] = [
                    'quantity' => intval($product['quantity']),
                    'buying_unit_cost' => doubleval($product['buying_unit_cost']),
                    'description' => $product['description'] ? $product['description'] : null,
                    'tax_rate' => doubleval($product['tax_rate']),
                    'total' => doubleval($product['total_buying_cost']),
                ];
            }
            $bill->products()->sync($syncable);
            $this->updateTotalDue($bill, $bill->payable);

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

    private function getFillable(BillRequest $request): array
    {
        $fillable = $request->validated();
        unset($fillable['products']);
        return $fillable;
    }

    private function updateTotalDue(Bill $bill, $paymentHistories): void
    {
        $totalPaid = $paymentHistories ? collect($paymentHistories)->sum('amount') : 0;

        $bill->update([
            'total_due' => abs($bill->total_amount - $totalPaid),
            'status' => $totalPaid >= $bill->total_amount ? PaymentStatus::PAID : PaymentStatus::DUE
        ]);

        $this->creditRecordService->updateSupplierCreditRecord($bill);
    }
}
