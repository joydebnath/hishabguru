<?php

namespace App\Services\Contact;

use App\Enums\Address\Addressable;
use App\Enums\Contact\ContactType;
use App\Models\Contact;

class ContactService
{
    protected $contactDetailsService, $addressService;

    public function __construct(ContactDetailsService $contactDetailsService, AddressService $addressService)
    {
        $this->contactDetailsService = $contactDetailsService;
        $this->addressService = $addressService;
    }

    public function create($storeable, $contactType): Contact
    {
        $contact = $this->store([
            'name' => $storeable['name'],
            'note' => isset($storeable['note']) ? $storeable['note'] : null,
            'tenant_id' => $storeable['tenant_id'],
            'type' => $contactType,
        ]);

        $this->addressService->create($contact->id, Addressable::CONTACT, $storeable);

        $this->contactDetailsService->create($contact->id, $storeable);

        if ($contactType === ContactType::SUPPLIER && isset($storeable['has_primary_contact'])) {
            $this->storePrimaryContactPerson($contact, $storeable);
        }

        return $contact;
    }

    private function store($storeable): Contact
    {
        return Contact::create([
            'name' => $storeable['name'],
            'note' => $storeable['note'],
            'tenant_id' => $storeable['tenant_id'],
            'type' => $storeable['type'],
        ]);
    }

    public function update($contactId, $updateable, $addressType): Contact
    {
        $contact = Contact::find($contactId);

        $contact->update([
            'name' => $updateable['name'],
            'note' => isset($updateable['note']) ? $updateable['note'] : null,
        ]);

        $address = $contact->addresses()->where('address_type', $addressType)->first();
        $this->addressService->update($address->id, $updateable);

        $this->contactDetailsService->update($contact->id, $updateable);

        if ($contact->type === ContactType::SUPPLIER && isset($updateable['has_primary_contact'])) {
            $this->updateOrCreatePrimaryContactPerson($contact, $updateable);
        }

        return $contact;
    }

    private function storePrimaryContactPerson($contact, $storeable): void
    {
        $primaryContact = $this->store([
            'name' => isset($storeable['primary_contact_person_name']) ? $storeable['primary_contact_person_name'] : 'Default Contact Person',
            'note' => 'Primary contact person.',
            'tenant_id' => $storeable['tenant_id'],
            'type' => ContactType::SUPPLIER_PRIMARY_PERSON,
        ]);

        $contact->child_contacts()->attach($primaryContact->id);

        $this->contactDetailsService->create($primaryContact->id, [
            'mobile' => isset($storeable['primary_contact_person_mobile']) ? $storeable['primary_contact_person_mobile'] : null,
            'phone' => isset($storeable['primary_contact_person_phone']) ? $storeable['primary_contact_person_phone'] : null,
            'email' => isset($storeable['primary_contact_person_email']) ? $storeable['primary_contact_person_email'] : null,
        ]);
    }

    private function updateOrCreatePrimaryContactPerson($contact, $updateable): void
    {
        if (isset($updateable['primary_contact_person_id'])) {
            $this->storePrimaryContactPerson($contact, $updateable);
            return;
        }

        $this->contactDetailsService->update($updateable['primary_contact_person_id'], [
            'mobile' => isset($updateable['primary_contact_person_mobile']) ? $updateable['primary_contact_person_mobile'] : null,
            'phone' => isset($updateable['primary_contact_person_phone']) ? $updateable['primary_contact_person_phone'] : null,
            'email' => isset($updateable['primary_contact_person_email']) ? $updateable['primary_contact_person_email'] : null,
        ]);
    }
}
