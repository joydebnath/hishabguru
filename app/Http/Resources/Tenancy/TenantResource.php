<?php

namespace App\Http\Resources\Tenancy;

use App\Http\Resources\Business\InventorySite;
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
            'tenant_id' => $this->id,
            'inventories' => new InventorySite($this->inventorySites),
        ];
    }
}
