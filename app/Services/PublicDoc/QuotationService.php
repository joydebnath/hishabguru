<?php

namespace App\Services\PublicDoc;

use App\Helpers\Helper;
use Carbon\Carbon;

class QuotationService
{
    public function decodePayload($quotationId)
    {
        return json_decode(base64_decode($quotationId));
    }

    public function validatePayload($payload)
    {
        return isset($payload->_id) && isset($payload->type);
    }

    public function parse($quotation)
    {
        return [
            'quotation' => json_encode($this->parseQuotation($quotation)),
            'products' => json_encode($this->parseProducts($quotation->products)),
            'from' => json_encode($this->parseFrom($quotation)),
            'for' => json_encode($this->parseFor($quotation)),
            'issued_by' => json_encode([
                'name' => $quotation->createdBy->name,
                'email' => $quotation->createdBy->email,
            ]),
            'currency' => $quotation->tenant->currency_of_operation,
        ];
    }

    private function parseQuotation($quotation)
    {
        return [
            '_id' => $quotation->id,
            'status' => $quotation->status,
            'payment_condition' => str_replace('-', ' ', $quotation->payment_condition),
            'quotation_number' => $quotation->quotation_number,
            'reference_number' => $quotation->reference_number ?? '---',
            'total_amount' => Helper::formatNumber($quotation->total_amount),
            'total' => $quotation->total_amount,
            'create_date' => Carbon::parse($quotation->create_date)->format('d/m/y'),
            'expiry_date' => $quotation->expiry_date ? Carbon::parse($quotation->expiry_date)->format('d/m/y') : '---',
        ];
    }

    private function parseFrom($quotation)
    {
        $businessAddress = collect($quotation->tenant->headquarter)->first();
        return [
            'name' => $quotation->tenant->name,
            'address' => $businessAddress->address_line_1 . ' ' . $businessAddress->address_line_2,
            'city' => $businessAddress->city,
            'postcode' => $businessAddress->postcode,
            'state' => $businessAddress->state,
            'country' => $businessAddress->country,
        ];
    }

    private function parseFor($quotation)
    {
        $clientAddress = collect($quotation->contact->home_address)->first();
        return [
            'name' => $quotation->contact->name,
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
                'discount' => $product->pivot->discount,
                'tax_rate' => $product->pivot->tax_rate,
                'total' => Helper::formatNumber($product->pivot->total),
            ]);
        }

        return $list;
    }
}
