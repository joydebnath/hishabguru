<?php


namespace App\Services\PrintDoc;


use App\Models\Contact;
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

    public function delivery()
    {
        return new DeliveryDetails([
            'delivery_address' => [
                'address' => '23 Main Street',
                'city' => 'Marineville',
                'state' => 'NSW',
                'postcode' => '2000'
            ],
            'delivery_instructions' => 'Regular order - deliver to Warehouse',
            'other_details' => [
                'phone' => '02 99998888'
            ],
        ]);
    }
}
