<?php

namespace App\Services\PublicDoc;

use App\Helpers\Helper;
use Carbon\Carbon;

class InvoiceService
{
    public function decodePayload($invoiceId)
    {
        return json_decode(base64_decode($invoiceId));
    }

    public function validatePayload($payload)
    {
        return isset($payload->_id) && isset($payload->type);
    }

    public function parse($invoice)
    {
        return [
            'invoice' => json_encode($this->parseInvoice($invoice)),
            'products' => json_encode($this->parseProducts($invoice->products)),
            'from' => json_encode($this->parseFrom($invoice)),
            'for' => json_encode($this->parseFor($invoice)),
            'issued_by' => json_encode([
                'name' => $invoice->createdBy->name,
                'email' => $invoice->createdBy->email,
            ]),
            'currency' => $invoice->tenant->currency_of_operation,
        ];
    }

    private function parseInvoice($invoice)
    {
        $totalPaid = $this->getTotalPaid($invoice->payable);
        return [
            '_id' => $invoice->id,
            'status' => $invoice->status,
            'invoice_number' => $invoice->invoice_number,
            'reference_number' => $invoice->reference_number ?? '---',
            'total_amount' => Helper::formatNumber($invoice->total_amount),
            'total_due' => Helper::formatNumber($invoice->total_due),
            'total_paid' => Helper::formatNumber($totalPaid),
            'total' => $invoice->total_amount,
            'due' => $invoice->total_due,
            'paid' => $totalPaid,
            'issue_date' => Carbon::parse($invoice->issue_date)->format('d/m/y'),
            'due_date' => $invoice->due_date ? Carbon::parse($invoice->due_date)->format('d/m/y') : '---',
        ];
    }

    private function parseFrom($invoice)
    {
        $businessAddress = collect($invoice->tenant->headquarter)->first();
        return [
            'name' => $invoice->tenant->name,
            'address' => $businessAddress->address_line_1 . ' ' . $businessAddress->address_line_2,
            'city' => $businessAddress->city,
            'postcode' => $businessAddress->postcode,
            'state' => $businessAddress->state,
            'country' => $businessAddress->country,
        ];
    }

    private function parseFor($invoice)
    {
        $clientAddress = collect($invoice->contact->home_address)->first();
        return [
            'name' => $invoice->contact->name,
            'address' => $clientAddress->address_line_1 . ' ' . $clientAddress->address_line_2,
            'city' => $clientAddress->city,
            'postcode' => $clientAddress->postcode,
            'state' => $clientAddress->state,
            'country' => $clientAddress->country,
        ];
    }

    private function parseProducts($products)
    {
        $list = [];
        foreach ($products as $product) {
            array_push($list, [
                'name' => $product->name,
                'code' => $product->code,
                'price' => Helper::formatNumber($product->selling_unit_price),
                'selling_price' => $product->selling_unit_price,
                'quantity' => $product->pivot->quantity,
                'discount' => Helper::formatNumber($product->pivot->discount) . '%',
                'discount_' => $product->pivot->discount,
                'tax_rate' => Helper::formatNumber($product->pivot->tax_rate) . '%',
                'tax_rate_' => $product->pivot->tax_rate,
                'total' => Helper::formatNumber($product->pivot->total),
            ]);
        }

        return $list;
    }

    private function getTotalPaid($payable)
    {
        return collect($payable)->sum('amount');
    }
}
