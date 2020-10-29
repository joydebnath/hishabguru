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
            $storable = $this->getQuotationFillable($request);

            $quotation = Quotation::create($storable);

            foreach ($request->products as $product) {
                $quotation->products()->attach($product['id'], [
                    'quantity' => $product['quantity'],
                    'discount' => $product['discount'],
                    'tax_rate' => $product['tax_rate'],
                    'total' => $product['total_selling_cost'],
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
            return new QuotationFullResource($quotation->load('contact', 'products','orders','invoices'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function update(QuotationRequest $request, Quotation $quotation)
    {
        try {
            $storable = $this->getQuotationFillable($request);

            $quotation->update($storable);

            $syncable = [];
            foreach ($request->products as $product) {
                $syncable[$product['id']] = [
                    'quantity' => intval($product['quantity']),
                    'discount' => doubleval($product['discount']),
                    'tax_rate' => doubleval($product['tax_rate']),
                    'total' => doubleval($product['total_selling_cost']),
                ];
            }
            $quotation->products()->sync($syncable);

            return new QuotationResource($quotation->load('contact'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function destroy(Quotation $quotation)
    {
        try {
            $quotation->invoices()->delete();
            $quotation->orders()->delete();
            $quotation->delete();
            return response(['message' => 'Quotation is deleted']);
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    /**
     * @param QuotationRequest $request
     * @return array
     */
    private function getQuotationFillable(QuotationRequest $request): array
    {
        $fillable = $request->validated();
        unset($fillable['products']);
        return $fillable;
    }
}
