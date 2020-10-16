<?php


namespace App\Services\Setting;

use App\Models\Address;
use App\Models\Tenant;
use App\Http\Resources\Setting\ContactDetails as ContactDetailsResource;
use App\Models\TenantDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactDetails implements SettingUpdatable
{
    public function update($tenantId, $request)
    {
        $this->updateBusinessAddress($request);

        $this->updateTenantDetails($request, $tenantId);

        return new ContactDetailsResource(
            Tenant::with('addresses', 'emails', 'phones', 'websites')->findOrFail($tenantId)
        );
    }

    private function updateBusinessAddress(Request $request)
    {
        $validator = Validator::make($request->headquarter, [
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string',
            'address_type' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'postcode' => 'required|string',
            'state' => 'required|string',
            'unit' => 'nullable|string'
        ]);

        $addressStorable = $validator->validated();

        Address::find($request->headquarter['id'])->update($addressStorable);
    }

    private function updateTenantDetails(Request $request, $tenantId): void
    {
        $contactStorable = $request->validate([
            'email' => 'nullable|string',
            'phone' => 'nullable|string',
            'website' => 'nullable|string',
        ]);

        foreach ($contactStorable as $key => $contact) {
            if ($contact) {
                TenantDetail::updateOrCreate([
                    'tenant_id' => $tenantId,
                    'key' => $key
                ], [
                    'value' => $contact
                ]);
            } else {
                TenantDetail::where([
                    'tenant_id' => $tenantId,
                    'key' => $key
                ])->delete();
            }
        }
    }
}
