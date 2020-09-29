<?php

namespace App\Services\Inventory;

use App\Models\InventorySite;

class InventoryService
{
    public function create($storable, $tenantId): InventorySite
    {
        return InventorySite::create([
            'name' => $storable['name'],
            'description' => $storable['description'],
            'tenant_id' => $tenantId,
        ]);
    }

    public function update($siteId, $updateable): InventorySite
    {
        return InventorySite::find($siteId)->update([
            'name' => $updateable['name'],
            'description' => $updateable['description'],
        ]);
    }
}
