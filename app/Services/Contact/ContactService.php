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

    public function create($storable, $contactType): Contact
    {
        $contact = $this->store([
            'name' => $storable['name'],
            'note' => isset($storable['note']) ? $storable['note'] : null,
            'tenant_id' => $storable['tenant_id'],
            'type' => $contactType,
        ]);

        if(isset($storable['addressable_type']) && $storable['addressable_type']){
            $this->addressService->create($contact->id, Addressable::CONTACT, $storable);
        }

        $this->contactDetailsService->create($contact->id, $storable);

        if ($contactType === ContactType::SUPPLIER && self::hasPrimaryContact($storable)) {
            $this->storePrimaryContactPerson($contact, $storable);
        }

        return $contact;
    }

    public function store($storable): Contact
    {
        return Contact::create([
            'name' => $storable['name'],
            'note' => $storable['note'],
            'tenant_id' => $storable['tenant_id'],
            'type' => $storable['type'],
        ]);
    }

    private function storePrimaryContactPerson($contact, $storable): Contact
    {
        $primaryContact = $this->store([
            'name' => isset($storable['primary_contact_person_name']) ? $storable['primary_contact_person_name'] : 'Default Contact Person',
            'note' => 'Primary contact person.',
            'tenant_id' => $storable['tenant_id'],
            'type' => ContactType::SUPPLIER_PRIMARY_PERSON,
        ]);

        $contact->child_contacts()->attach($primaryContact->id);

        $this->contactDetailsService->create($primaryContact->id, [
            'mobile' => isset($storable['primary_contact_person_mobile']) ? $storable['primary_contact_person_mobile'] : null,
            'phone' => isset($storable['primary_contact_person_phone']) ? $storable['primary_contact_person_phone'] : null,
            'email' => isset($storable['primary_contact_person_email']) ? $storable['primary_contact_person_email'] : null,
        ]);

        return $primaryContact;
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

        if ($contact->type === ContactType::SUPPLIER && self::hasPrimaryContact($updateable)) {
            $this->updateOrCreatePrimaryContactPerson($contact, $updateable);
        }

        return $contact;
    }

    private function updateOrCreatePrimaryContactPerson($contact, $updateable): void
    {
        if (isset($updateable['primary_contact_person_id']) && $updateable['primary_contact_person_id'] !== null) {
            $this->contactDetailsService->update($updateable['primary_contact_person_id'], [
                'mobile' => isset($updateable['primary_contact_person_mobile']) ? $updateable['primary_contact_person_mobile'] : null,
                'phone' => isset($updateable['primary_contact_person_phone']) ? $updateable['primary_contact_person_phone'] : null,
                'email' => isset($updateable['primary_contact_person_email']) ? $updateable['primary_contact_person_email'] : null,
            ]);
        }
        $this->storePrimaryContactPerson($contact, $updateable);
    }

    private static function hasPrimaryContact(array $data): bool
    {
        return isset($data['has_primary_contact']) && $data['has_primary_contact'];
    }
}
