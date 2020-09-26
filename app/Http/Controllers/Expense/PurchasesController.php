<?php

namespace App\Http\Controllers\Expense;

use App\Filters\Expense\PurchaseFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Expense\PurchaseRequest;
use App\Http\Resources\Expense\PurchaseCollection;
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
        //
    }

    public function show(Purchase $purchase)
    {
        //
    }

    public function update(PurchaseRequest $request, Purchase $purchase)
    {
        //
    }

    public function destroy(Purchase $purchase)
    {
        //
    }
}
