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
            'total' => doubleval($this->selling_unit_price),
            'selling_unit_price' => doubleval($this->selling_unit_price),
            'tax_rate' => doubleval($this->tax_rat),
            'edit' => false
//            'description' => $this->description,
        ];
    }
}
