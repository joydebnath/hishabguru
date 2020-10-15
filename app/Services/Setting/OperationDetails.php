<?php


namespace App\Services\Setting;

use App\Http\Resources\Setting\OperationDetails as OperationDetailsResource;
use App\Models\Tenant;

class OperationDetails implements SettingUpdatable
{

    public function update($tenantId, $request)
    {
        $storable = $request->validate([
            'country' => 'required|max:255',
            'currency' => 'required|max:255',
        ]);

        Tenant::findOrFail($tenantId)->update([
            'country_of_operation' => $storable['country'],
            'currency_of_operation' => $storable['currency']
        ]);

        return new OperationDetailsResource(Tenant::findOrFail($tenantId));
    }
}
