<?php

namespace App\Http\Controllers\Expense;

use App\Filters\Expense\PurchaseFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Expense\PurchaseRequest;
use App\Http\Resources\Expense\PurchaseCollection;
use App\Http\Resources\Expense\Purchase as PurchaseResource;
use App\Http\Resources\Expense\PurchaseFullResource;
use App\Models\CopyReference;
use App\Models\Purchase;
use Exception;

class PurchasesController extends Controller
{
    public function index(PurchaseFilter $filters)
    {
        try {
            return new PurchaseCollection(
                Purchase::filter($filters)->paginate()
            );
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function store(PurchaseRequest $request)
    {
        try {
            $storable = $this->getFillable($request);
            $purchaseOrder = Purchase::create($storable);

            foreach ($request->products as $product) {
                $purchaseOrder->products()->attach($product['id'], [
                    'quantity' => intval($product['quantity']),
                    'buying_unit_cost' => doubleval($product['buying_unit_cost']),
                    'discount' => doubleval($product['discount']),
                    'tax_rate' => doubleval($product['tax_rate']),
                    'total' => doubleval($product['total_buying_cost']),
                ]);
            }

            return new PurchaseResource($purchaseOrder->load('contact'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function show(Purchase $purchase)
    {
        try {
            return new PurchaseFullResource($purchase->load('contact', 'products', 'deliverySite', 'bills'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function update(PurchaseRequest $request, Purchase $purchase)
    {
        try {
            $storable = $this->getFillable($request);
            $purchase->update($storable);

            $syncable = [];
            foreach ($request->products as $product) {
                $syncable[$product['id']] = [
                    'quantity' => intval($product['quantity']),
                    'buying_unit_cost' => doubleval($product['buying_unit_cost']),
                    'discount' => doubleval($product['discount']),
                    'tax_rate' => doubleval($product['tax_rate']),
                    'total' => doubleval($product['total_buying_cost']),
                ];
            }
            $purchase->products()->sync($syncable);

            return new PurchaseResource($purchase->load('contact'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function destroy(Purchase $purchase)
    {
        try {
            CopyReference::where('copy_from_id', $purchase->id)->where('copy_from_type', 'purchases')->delete();
            $purchase->delete();
            return response(['message' => 'Purchase Order is deleted']);
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    private function getFillable(PurchaseRequest $request): array
    {
        $fillable = $request->validated();
        unset($fillable['products']);
        return $fillable;
    }
}
