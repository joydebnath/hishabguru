<?php

namespace App\Http\Resources\Business;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderFullResource extends JsonResource
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
            'order_number' => $this->order_number,
            'reference_number' => $this->reference_number,
            'delivery_details' => self::deliveryDetails($this->deliveryDetails),
            'create_date' => $this->create_date,
            'delivery_date' => $this->delivery_date,
            'products' => self::products($this->products)
        ];
    }

    private static function products($products)
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

    private static function deliveryDetails($details)
    {
        if ($details) {
            return [
                'delivery_details_id' => $details->id,
                'address' => $details->address,
                'delivery_contact_number' => $details->contact_number,
                'delivery_instructions' => $details->instructions,
            ];
        }
        return null;
    }
}
