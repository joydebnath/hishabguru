<?php

namespace App\Http\Controllers\Expense;

use App\Filters\Expense\BillFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Expense\BillRequest;
use App\Http\Resources\Expense\BillCollection;
use App\Http\Resources\Expense\BillFullResource;
use App\Models\Bill;
use App\Http\Resources\Expense\Bill as BillResource;
use Exception;

class BillsController extends Controller
{
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

            return new BillResource($bill->load('contact'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function destroy(Bill $bill)
    {
        try {
            $bill->payable()->delete();
            $bill->delete();
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
}
