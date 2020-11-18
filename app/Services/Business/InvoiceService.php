<?php

namespace App\Services\Business;

use App\Enums\Business\InvoiceStatus;
use App\Enums\Status\PaymentStatus;
use App\Http\Requests\Business\InvoiceRequest;
use App\Models\Invoice;
use App\Services\Payment\CreditRecordService;

class InvoiceService
{
    public function create(InvoiceRequest $request)
    {
        $storable = $this->getFillable($request);
        if ($request->status !== 'draft') {
            $storable['total_due'] = $request->total_amount;
        }

        $invoice = Invoice::create($storable);

        foreach ($request->products as $product) {
            $invoice->products()->attach($product['id'], [
                'quantity' => intval($product['quantity']),
                'discount' => doubleval($product['discount']),
                'tax_rate' => doubleval($product['tax_rate']),
                'total' => doubleval($product['total_selling_cost']),
            ]);
        }

        $this->updateProductQuantity($invoice);

        return $invoice;
    }

    public function update(InvoiceRequest $request, Invoice $invoice)
    {
        $storable = $this->getFillable($request);
        $invoice->update($storable);

        $syncable = [];
        foreach ($request->products as $product) {
            $syncable[$product['id']] = [
                'quantity' => intval($product['quantity']),
                'discount' => doubleval($product['discount']),
                'tax_rate' => doubleval($product['tax_rate']),
                'total' => doubleval($product['total_selling_cost']),
            ];
        }

        $invoice->products()->sync($syncable);
        $this->updateTotalDue($invoice, $invoice->payable);
    }

    private function getFillable(InvoiceRequest $request): array
    {
        $fillable = $request->validated();
        unset($fillable['products']);
        return $fillable;
    }

    private function updateTotalDue(Invoice $invoice, $paymentHistories): void
    {
        $totalPaid = $paymentHistories ? collect($paymentHistories)->sum('amount') : 0;
        $updatable = [
            'total_due' => abs($invoice->total_amount - $totalPaid)
        ];

        if ($invoice->status === PaymentStatus::DUE) {
            $updatable['status'] = $totalPaid >= $invoice->total_amount ? PaymentStatus::PAID : PaymentStatus::DUE;
        }

        $invoice->update($updatable);

        (new CreditRecordService)->updateClientCreditRecord($invoice);
    }

    private function updateProductQuantity(Invoice $invoice)
    {
        if ((in_array($invoice->status, [InvoiceStatus::PAID, InvoiceStatus::DUE]))) {
            $products = $invoice->products;
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
