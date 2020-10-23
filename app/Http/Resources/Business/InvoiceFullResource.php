<?php

namespace App\Http\Resources\Business;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceFullResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'contact' => isset($this->contact) ? ['id' => $this->contact->id, 'name' => $this->contact->name] : null,
            'contact_id' => $this->contact_id,
            'invoice_number' => $this->invoice_number,
            'reference_number' => $this->reference_number,
            'issue_date' => $this->issue_date,
            'due_date' => $this->due_date,
            'status' => $this->status,
            'read_only' => $this->status !== 'draft',
            'note' => $this->note,
            'products' => self::products($this->products),
            'total_due' => $this->total_due,
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
                'quantity' => doubleval($pivot->get('quantity', null)),
                'discount' => doubleval($pivot->get('discount', null)),
                'tax_rate' => doubleval($pivot->get('tax_rate', null)),
                'total_selling_cost' => doubleval($pivot->get('total', null)),
                'edit' => false
            ];
        });
    }

    private static function getProfitPercentage($total_selling_price, $buying_price, $quantity)
    {
        $total_buying_cost = $buying_price * $quantity;
        return round((($total_selling_price - $total_buying_cost) / $total_buying_cost) * 100, 2);
    }
}
