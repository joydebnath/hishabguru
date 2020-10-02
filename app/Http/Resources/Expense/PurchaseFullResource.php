<?php

namespace App\Http\Resources\Expense;

use App\Http\Resources\Business\InventorySite;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseFullResource extends JsonResource
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
            'purchase_order_number' => $this->purchase_order_number,
            'reference_number' => $this->reference_number,
            'create_date' => $this->create_date,
            'delivery_date' => $this->delivery_date,
            'delivery_site' => new InventorySite($this->delivery_site),
            'products' => self::products($this->products),
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
                'buying_unit_cost' => doubleval($pivot->get('buying_unit_cost', null)),
                'quantity' => doubleval($pivot->get('quantity', null)),
                'discount' => doubleval($pivot->get('discount', null)),
                'tax_rate' => doubleval($pivot->get('tax_rate', null)),
                'total_buying_cost' => doubleval($pivot->get('total', null)),
                'edit' => false
            ];
        });
    }
}
