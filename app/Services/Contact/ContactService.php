<?php

namespace App\Services\Contact;

use App\Enums\Address\Addressable;
use App\Enums\Address\AddressType;
use App\Models\Contact;

class ContactService
{
    protected $contactDetailsService, $addressService;

    public function __construct(ContactDetailsService $contactDetailsService, AddressService $addressService)
    {
        $this->contactDetailsService = $contactDetailsService;
        $this->addressService = $addressService;
    }

    public function create($storeable, $contactType)
    {
        $contact = Contact::create([
            'name' => $storeable['name'],
            'note' => $storeable['note'],
            'tenant_id' => $storeable['tenant_id'],
            'type' => $contactType,
        ]);

        $this->addressService->create($contact->id, Addressable::CONTACT, $storeable);

        $this->contactDetailsService->create($contact->id, $storeable);

        return $contact;
    }

    public function update($contactId, $updateable, $addressType = 'home_address')
    {
        $contact = Contact::find($contactId);
        $contact->update([
            'name' => $updateable['name'],
            'note' => $updateable['note'],
        ]);

        $address = $contact->{$addressType}->first();
        $this->addressService->update($address->id, $updateable);

        $this->contactDetailsService->update($contact->id, $updateable);

        return $contact;
    }
}
