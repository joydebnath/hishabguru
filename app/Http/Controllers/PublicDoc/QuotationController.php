<?php

namespace App\Http\Controllers\PublicDoc;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use App\Services\PublicDoc\QuotationService;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    protected $service;

    public function __construct(QuotationService $service)
    {
        $this->service = $service;
    }

    public function show($payload)
    {
        $payload = $this->service->decodePayload($payload);

        if ($this->service->validatePayload($payload)) {
            $quote = Quotation::with('products', 'tenant.headquarter', 'contact.home_address', 'createdBy')
                ->findOrFail($payload->_id);

            list(
                'quotation' => $quotation,
                'products' => $products,
                'from' => $from,
                'for' => $for,
                'issued_by' => $issued_by,
                'currency' => $currency
                ) = $this->service->parse($quote);

            return view('guest.quotation', compact('quotation', 'products', 'from', 'for', 'issued_by', 'currency'));
        }

        abort(404);
    }

    public function update(Request $request, $quotationId)
    {

    }
}
