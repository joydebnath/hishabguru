<?php


namespace App\Services\Setting;

use App\Http\Resources\Setting\BusinessDetails as BusinessDetailsResource;
use App\Models\Tenant;

class BusinessDetails implements SettingUpdatable
{

    public function update($tenantId, $request)
    {
        $storable = $request->validate([
            'name' => 'required|string|max:255',
            'business_type' => 'nullable|string',
            'tax_file_number' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        Tenant::findOrFail($tenantId)->update($storable);

        return new BusinessDetailsResource(Tenant::findOrFail($tenantId));
    }
}
