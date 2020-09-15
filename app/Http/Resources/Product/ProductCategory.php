<?php

namespace App\Http\Resources\Product;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategory extends JsonResource
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
            'name' => $this->name,
            'parent_category' => $this->parent_category ? $this->parent_category->name : null,
            'parent_id' => $this->parent_category ? $this->parent_category->id : null,
            'formatted_created_at' => Carbon::parse($this->created_at)->format('d M, Y'),
            'note'=> $this->note,
        ];
    }
}
