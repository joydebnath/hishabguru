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
                'profit' => self::getProfitPercentage(
                    doubleval($pivot->get('total', 0)),
                    doubleval($product->buying_unit_cost),
                    doubleval($pivot->get('quantity', 0))
                ),
                'quantity' => doubleval($pivot->get('quantity', 0)),
                'discount' => doubleval($pivot->get('discount', 0)),
                'tax_rate' => doubleval($pivot->get('tax_rate', 0)),
                'total_selling_cost' => doubleval($pivot->get('total', 0)),
                'edit' => false
            ];
        });
    }

    private static function getProfitPercentage($total_selling_price, $buying_price, $quantity)
    {
        $total_buying_cost = $buying_price * $quantity;
        return round((($total_selling_price - $total_buying_cost) / $total_buying_cost) * 100, 2);
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
