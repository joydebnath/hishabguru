<?php

namespace App\Http\Resources\Tenancy;

use App\Http\Resources\Business\InventorySiteCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class TenantResource extends JsonResource
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
            'inventories' => new InventorySiteCollection($this->inventorySites),
        ];
    }
}
