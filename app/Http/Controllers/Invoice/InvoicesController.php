<?php

namespace App\Http\Controllers\Invoice;

use App\Enums\Status\PaymentStatus;
use App\Filters\Business\InvoiceFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Business\InvoiceRequest;
use App\Http\Resources\Business\InvoiceCollection;
use App\Http\Resources\Business\InvoiceFullResource;
use App\Models\Invoice;
use App\Http\Resources\Business\Invoice as InvoiceResource;
use Exception;

class InvoicesController extends Controller
{
    public function index(InvoiceFilter $filters)
    {
        try {
            return new InvoiceCollection(
                Invoice::filter($filters)->paginate()
            );
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function store(InvoiceRequest $request)
    {
        try {
            $storable = $this->getFillable($request);
            if ($request->status !== 'draft') {
                $storable['total_due'] = $request->total_amount;
            }
            $invoice = Invoice::create($storable);

            foreach ($request->products as $product) {
                $invoice->products()->attach($product['id'], [
                    'quantity' => intval($product['quantity']),
                    'buying_unit_cost' => doubleval($product['buying_unit_cost']),
                    'description' => $product['description'] ? $product['description'] : null,
                    'tax_rate' => doubleval($product['tax_rate']),
                    'total' => doubleval($product['total_buying_cost']),
                ]);
            }

            return new InvoiceResource($invoice->load('contact'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function show(Invoice $invoice)
    {
        try {
            return new InvoiceFullResource($invoice->load('contact', 'products'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function update(InvoiceRequest $request, Invoice $invoice)
    {
        try {
            $storable = $this->getFillable($request);
            $invoice->update($storable);

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
            $invoice->products()->sync($syncable);
            $this->updateTotalDue($invoice, $invoice->payable);

            return new InvoiceResource($invoice->load('contact'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function destroy(Invoice $invoice)
    {
        try {
            $invoice->payable()->delete();
            $invoice->delete();
            return response(['message' => 'Bill is deleted']);
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    private function getFillable(InvoiceRequest $request): array
    {
        $fillable = $request->validated();
        unset($fillable['products']);
        return $fillable;
    }

    private function updateTotalDue($expense, $paymentHistories): void
    {
        $totalPaid = $paymentHistories ? collect($paymentHistories)->sum('amount') : 0;

        $expense->update([
            'total_due' => abs($expense->total_amount - $totalPaid),
            'status' => $totalPaid >= $expense->total_amount ? PaymentStatus::PAID : PaymentStatus::DUE
        ]);
    }
}
