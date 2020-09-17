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
            'selling_price' => $this->selling_unit_price,
            'sell' => number_format($this->selling_unit_price, 2),
            'tax' => $this->tax_rate,
            'description' => $this->description
        ];
    }
}
