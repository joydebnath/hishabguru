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
                    'total' => $product['tax_rate'],
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
            return new QuotationFullResource($quotation->load('contact'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function update(QuotationRequest $request, Quotation $quotation)
    {
        return $request->validated();
    }

    public function destroy(Quotation $quotation)
    {
        //
    }
}
