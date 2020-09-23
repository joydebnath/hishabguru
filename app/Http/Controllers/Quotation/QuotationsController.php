<?php

namespace App\Http\Controllers\Quotation;

use App\Filters\Business\QuotationFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Business\QuotationRequest;
use App\Http\Resources\Business\QuotationCollection;
use App\Http\Resources\Business\QuotationFullResource;
use App\Models\Quotation;
use App\Http\Resources\Business\Quotation as QuotationResource;
use Exception;

class QuotationsController extends Controller
{
    public function index(QuotationFilter $filters)
    {
        try {
            return new QuotationCollection(
                Quotation::filter($filters)->paginate()
            );
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function store(QuotationRequest $request)
    {
        try {
            $storable = $request->validated();
            unset($storable['products']);

            $quotation = Quotation::create($storable);

            foreach ($request->products as $product) {
                $quotation->products()->attach($product['id'], [
                    'quantity' => $product['quantity'],
                    'discount' => $product['discount'],
                    'tax_rate' => $product['tax_rate'],
                    'total' => $product['total'],
                ]);
            }

            return new QuotationResource($quotation->load('contact'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function show(Quotation $quotation)
    {
        try {
            return new QuotationFullResource($quotation->load('contact', 'products'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function update(QuotationRequest $request, Quotation $quotation)
    {
        try {
            $storable = $request->validated();
            unset($storable['products']);

            $quotation->update($storable);

            if (collect($request->products)->isNotEmpty()) {
                foreach ($request->products as $product) {
                    $syncable[$product['id']] = [
                        'quantity' => intval($product['quantity']),
                        'discount' => doubleval($product['discount']),
                        'tax_rate' => doubleval($product['tax_rate']),
                        'total' => doubleval($product['total']),
                    ];
                }
                $quotation->products()->sync($syncable);
            }

            return new QuotationResource($quotation->load('contact'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function destroy(Quotation $quotation)
    {
        try {
            $quotation->delete();
            return response(['message' => 'Quotation is deleted']);
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }
}
