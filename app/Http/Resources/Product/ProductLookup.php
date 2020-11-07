<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductLookup extends JsonResource
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
            'name' => $this->name,
            'code' => $this->code,
            'quantity' => 1,
            'discount' => null,
            'total_selling_cost' => doubleval($this->selling_unit_price),
            'total_buying_cost' => doubleval($this->buying_unit_cost),
            'selling_unit_price' => doubleval($this->selling_unit_price),
            'buying_unit_cost' => doubleval($this->buying_unit_cost),
            'tax_rate' => doubleval($this->tax_rat),
            'edit' => false,
            'description' => $this->description,
            'profit' => $this->getProfitPercentage(),
        ];
    }

    private function getProfitPercentage()
    {
        return round(((doubleval($this->selling_unit_price) - doubleval($this->buying_unit_cost)) / doubleval($this->buying_unit_cost)) * 100, 2);
    }
}
