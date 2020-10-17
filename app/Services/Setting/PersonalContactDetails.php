<?php


namespace App\Services\Setting;


use App\Enums\Address\Addressable;
use App\Enums\Address\AddressType;
use App\Models\Address;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Setting\PersonalContactDetails as PersonalContactDetailsResource;

class PersonalContactDetails implements SettingUpdatable
{

    public function update($tenantId, Request $request)
    {
        $user = Auth::user();

        $this->updateUserAddress($user, $request);
        $this->updateDetails($user, $request);

        return new PersonalContactDetailsResource(
            $user->load([
                'details' => function ($query) {
                    $query->where('tenant_id', null);
                },
                'addresses' => function ($query) {
                    $query->firstWhere('address_type', AddressType::HOME);
                }
            ])
        );
    }

    private function updateUserAddress($user, Request $request)
    {
        $validator = Validator::make($request->address, [
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'postcode' => 'required|string',
            'state' => 'required|string',
            'unit' => 'nullable|string'
        ]);

        $addressStorable = $validator->validated();

        Address::updateOrCreate([
            'addressable_type' => Addressable::USER,
            'addressable_id' => $user->id,
            'address_type' => AddressType::HOME
        ], $addressStorable);
    }

    private function updateDetails($user, Request $request): void
    {
        $details = $request->validate([
            'phone' => 'nullable|string|max:255',
        ]);

        foreach ($details as $key => $detail) {
            if ($detail) {
                UserDetail::updateOrCreate(
                    ['user_id' => $user->id, 'tenant_id' => null, 'key' => $key],
                    ['value' => $detail]
                );
            } else {
                UserDetail::where(
                    ['user_id' => $user->id, 'tenant_id' => null, 'key' => $key]
                )->delete();
            }
        }
    }
}
