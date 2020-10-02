<?php

namespace App\Http\Resources\Expense;

use Illuminate\Http\Resources\Json\JsonResource;

class BillFullResource extends JsonResource
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
            'bill_number' => $this->bill_number,
            'reference_number' => $this->reference_number,
            'issue_date' => $this->issue_date,
            'due_date' => $this->due_date,
            'note' => $this->note,
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
                'description' => $pivot->get('description', null),
                'tax_rate' => doubleval($pivot->get('tax_rate', null)),
                'total_buying_cost' => doubleval($pivot->get('total', null)),
                'edit' => false
            ];
        });
    }
}
