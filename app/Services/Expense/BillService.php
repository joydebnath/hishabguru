<?php

namespace App\Services\Expense;

use App\Enums\Business\InvoiceStatus;
use App\Enums\Status\PaymentStatus;
use App\Http\Requests\Expense\BillRequest;
use App\Models\Bill;
use App\Services\Payment\CreditRecordService;

class BillService
{
    public function create(BillRequest $request)
    {
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

        $this->updateProductQuantity($bill);

        return $bill;
    }

    public function update(BillRequest $request, Bill $bill)
    {
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

        (new CreditRecordService)->updateSupplierCreditRecord($bill);
    }

    private function updateProductQuantity(Bill $bill)
    {
        if ((in_array($bill->status, [InvoiceStatus::PAID, InvoiceStatus::DUE]))) {
            $products = $bill->products;
            foreach ($products as $product) {
                if ($product->quantity > 0) {
                    $product->update([
                        'quantity' => $product->quantity - $product->pivot->quantity
                    ]);
                }
            }
        }
    }
}
