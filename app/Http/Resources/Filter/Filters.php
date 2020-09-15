<?php

namespace App\Http\Resources\Filter;

use App\Http\Resources\Filter\Product\CategoryCollection;
use App\Http\Resources\Product\ProductCategory;
use Illuminate\Http\Resources\Json\JsonResource;

class Filters extends JsonResource
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
            'product_categories' => new CategoryCollection($this->product_categories)
        ];
    }
}
