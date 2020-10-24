<?php


namespace App\Services\PrintDoc;


use App\Models\Contact;
use App\Models\Tenant;
use LaravelDaily\Invoices\Classes\Party;

class PrintDocService
{
    public function contact(Contact $contact)
    {
        $contact = $contact->load('addresses', 'mobiles');
        $address = collect($contact->addresses)->first();
        $mobile = collect($contact->mobiles)->first();

        return new Party([
            'name' => $contact->name,
            'address' => $address ? $address->address_line_1 . ', ' . $address->city . ', ' . $address->postcode : '',
            'custom_fields' => [
                'Phone' => $mobile ? $mobile->value : null,
            ],
        ]);
    }

    public function tenant(Tenant $tenant)
    {
        $contact = $tenant->load('headquarter', 'phones');
        $address = collect($tenant->headquarter)->first();
        $phone = collect($tenant->phones)->first();

        return new Party([
            'name' => $contact->name,
            'address' => $address ? $address->address_line_1 . ', ' . $address->city . ', ' . $address->postcode : '',
            'custom_fields' => [
                'Phone' => $phone ? $phone->value : null,
            ],
        ]);
    }

    public function delivery($details)
    {
        return new DeliveryDetails($details);
    }
}
