<?php

namespace App\Services\Contact;

use App\Models\Address;

class AddressService
{
    public function create($addressableId, $addressableType, $storeable): Address
    {
        return
            Address::create([
                'addressable_type' => $addressableType,
                'addressable_id' => $addressableId,
                'address_line_1' => $storeable['address_line_1'],
                'address_line_2' => isset($storeable['address_line_2']) ? $storeable['address_line_2'] : null,
                'city' => $storeable['city'],
                'postcode' => $storeable['postcode'],
                'state' => $storeable['state'],
                'country' => $storeable['country'],
                'address_type' => $storeable['address_type']
            ]);
    }

    public function update($addressId, $updateable): bool
    {
        return
            Address::find($addressId)->update([
                'address_line_1' => $updateable['address_line_1'],
                'address_line_2' => $updateable['address_line_2'],
                'city' => $updateable['city'],
                'postcode' => $updateable['postcode'],
                'state' => $updateable['state'],
                'country' => $updateable['country'],
            ]);
    }
}
