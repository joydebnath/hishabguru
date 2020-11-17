<?php

namespace App\Http\Controllers\PublicDoc;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Services\PublicDoc\InvoiceService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    protected $service;

    public function __construct(InvoiceService $service)
    {
        $this->service = $service;
    }

    public function show($payload)
    {
        $payload = $this->service->decodePayload($payload);

        if ($this->service->validatePayload($payload)) {
            $inv = Invoice::with('products', 'tenant.headquarter', 'contact.home_address', 'createdBy', 'payable')
                ->findOrFail($payload->_id);

            list(
                'invoice' => $invoice,
                'products' => $products,
                'from' => $from,
                'for' => $for,
                'issued_by' => $issued_by,
                'currency' => $currency
                ) = $this->service->parse($inv);

            return view('guest.invoice', compact('invoice', 'products', 'from', 'for', 'issued_by', 'currency'));
        }

        abort(404);
    }

    public function update(Request $request, $invoiceId)
    {

    }
}
