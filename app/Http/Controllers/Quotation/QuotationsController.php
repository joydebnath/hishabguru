<?php

namespace App\Http\Controllers\Quotation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Business\QuotationRequest;
use App\Models\Quotation;

class QuotationsController extends Controller
{
    public function index()
    {

    }

    public function store(QuotationRequest $request)
    {
        return $request->validated();
    }

    public function show(Quotation $quotation)
    {
        //
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
