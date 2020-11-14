<?php


namespace App\Services\ImportData;


use App\Enums\Address\Addressable;
use App\Enums\Address\AddressType;
use App\Enums\Contact\ContactType;
use App\Models\Contact;
use App\Services\Contact\AddressService;
use App\Services\Contact\ContactDetailsService;

class StoreSupplier implements Importable
{

    protected $contactDetailsService, $addressService;

    public function __construct(ContactDetailsService $contactDetailsService, AddressService $addressService)
    {
        $this->contactDetailsService = $contactDetailsService;
        $this->addressService = $addressService;
    }

    public function import($records)
    {
        foreach ($records as $record) {
            $contact = $this->storeContact($record);
            $this->addressService->create(
                $contact->id,
                Addressable::CONTACT,
                $this->parseAddress($record)
            );
            $this->contactDetailsService->create($contact->id, $this->parseContactDetails($record));

            $primaryContactPerson = $this->parseContactPerson($record);

            if ($primaryContactPerson['primary_contact_person_name']) {
                $this->storePrimaryContact($contact, $primaryContactPerson);
            }
        }
        return response(['message' => 'Suppliers imported successfully'], 201);
    }

    private function storeContact($record): Contact
    {
        return Contact::create([
            'name' => $record['Company Name'],
            'note' => $record['Note'],
            'tenant_id' => $record['tenant_id'],
            'type' => ContactType::SUPPLIER,
            'is_active' => true
        ]);
    }

    private function storePrimaryContact($contact, $storable): Contact
    {
        $primaryContact = Contact::create([
            'name' => $storable['primary_contact_person_name'] ? $storable['primary_contact_person_name'] : 'Default Contact Person',
            'note' => 'Primary contact person.',
            'tenant_id' => $storable['tenant_id'],
            'type' => ContactType::SUPPLIER_PRIMARY_PERSON,
        ]);

        $contact->child_contacts()->attach($primaryContact->id);

        $this->contactDetailsService->create($primaryContact->id, [
            'mobile' => $storable['primary_contact_person_mobile'],
            'email' => $storable['primary_contact_person_email'],
        ]);

        return $primaryContact;
    }

    private function parseContactDetails($record)
    {
        return [
            'email' => $record['Email'],
            'mobile' => $record['Mobile'],
            'phone' => $record['Phone'],
        ];
    }

    private function parseAddress($record)
    {
        return [
            'address_line_1' => $record['Contact Address'],
            'city' => $record['City'],
            'postcode' => $record['Postcode'],
            'state' => $record['State/Division'],
            'country' => $record['Country'],
            'address_type' => AddressType::HOME
        ];
    }

    private function parseContactPerson($record)
    {
        return [
            'primary_contact_person_name' => $record['Contact Person Name'],
            'primary_contact_person_mobile' => $record['Contact Person Mobile'],
            'primary_contact_person_email' => $record['Contact Person Email'],
            'tenant_id' => $record['tenant_id'],
        ];
    }
}
