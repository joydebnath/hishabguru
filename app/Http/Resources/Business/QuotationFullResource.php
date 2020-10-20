<?php

namespace App\Http\Resources\Business;

use Illuminate\Http\Resources\Json\JsonResource;

class QuotationFullResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'contact' => isset($this->contact) ? ['id' => $this->contact->id, 'name' => $this->contact->name] : null,
            'contact_id' => $this->contact_id,
            'quotation_number' => $this->quotation_number,
            'reference_number' => $this->reference_number,
            'payment_condition' => $this->payment_condition,
            'minimum_payment_amount' => $this->minimum_payment_amount,
            'note' => $this->note,
            'status' => $this->status,
            'create_date' => $this->create_date,
            'expiry_date' => $this->expiry_date,
            'products' => self::products($this->products)
        ];
    }

    protected static function products($products)
    {
        return collect($products)->map(function ($product) {
            $pivot = collect($product->pivot);
            return [
                'id' => $product->id,
                'name' => $product->name,
                'code' => $product->code,
                'selling_unit_price' => doubleval($product->selling_unit_price),
                'quantity' => doubleval($pivot->get('quantity', null)),
                'discount' => doubleval($pivot->get('discount', null)),
                'tax_rate' => doubleval($pivot->get('tax_rate', null)),
                'total_selling_cost' => doubleval($pivot->get('total', null)),
                'edit' => false
            ];
        });
    }
}
