<?php


namespace App\Services\ImportData;


use App\Enums\Address\Addressable;
use App\Enums\Address\AddressType;
use App\Enums\Contact\ContactType;
use App\Models\Contact;
use App\Services\Contact\AddressService;
use App\Services\Contact\ContactDetailsService;

class StoreClient implements Importable
{
    protected $contactDetailsService, $addressService;

    public function __construct()
    {
        $this->contactDetailsService = new ContactDetailsService;
        $this->addressService = new AddressService;
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
        }
        return response(['message' => 'Clients imported successfully'], 201);
    }

    private function storeContact($record): Contact
    {
        return Contact::create([
            'name' => $record['Full Name'],
            'note' => $record['Note'],
            'tenant_id' => $record['tenant_id'],
            'type' => ContactType::CLIENT,
            'is_active' => true
        ]);
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
}
