<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
            'buying_cost' => $this->buying_unit_cost,
            'cost' => number_format($this->buying_unit_cost,'2'),
            'selling_price' => $this->selling_unit_price,
            'sell' => number_format($this->selling_unit_price,2),
            'quantity' => $this->quantity,
            'category' => $this->product_category->name,
            'category_id' => $this->product_category->id,
            'tax' => $this->tax_rate,
            'description' => $this->description
        ];
    }
}
