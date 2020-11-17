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
use App\Services\Business\InvoiceService;
use App\Services\Payment\CreditRecordService;
use Exception;

class InvoicesController extends Controller
{
    protected $service;

    public function __construct(InvoiceService $service)
    {
        $this->service = $service;
    }

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
            $invoice = $this->service->create($request);
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
            $this->service->update($request, $invoice);
            return new InvoiceResource($invoice->load('contact'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function destroy(Invoice $invoice)
    {
        try {
            $invoice->delete(); // This triggers InvoiceObserver
            return response(['message' => 'Invoice is deleted']);
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }
}
