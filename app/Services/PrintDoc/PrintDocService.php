<?php


namespace App\Services\PrintDoc;


use App\Models\Contact;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;

class PrintDocService
{
    public function generate()
    {
        $client = $this->from(null);

        $customer = $this->for(null);

        $deliveryDetails = $this->delivery();

        $items = $this->products();

        $notes = 'Thank you!';

        $invoice = ExtendedInvoice::make('Invoice')
            ->sequence(667)//
            ->serialNumberFormat('{SEQUENCE}')//
            ->seller($client)//
            ->buyer($customer)//
            ->date(now()->subWeeks(3))//
            ->addDeliveryDate(now())//
            ->addDeliveryDetails($deliveryDetails)
//            ->addDueDate(now())
//            ->addExpiryDate(now())
            ->dateFormat('d/m/Y') //
            ->currencySymbol('BDT') //
            ->currencyCode('BDT') //
            ->currencyFormat('{VALUE} {SYMBOL}') //
            ->currencyThousandsSeparator(',') //
            ->currencyDecimalPoint('.') //
            ->filename($client->name . ' ' . $customer->name)//
            ->addItems($items)//
            ->addMessage($notes)//
            ->logo('https://i.pinimg.com/originals/33/b8/69/33b869f90619e81763dbf1fccc896d8d.jpg')//
            ->save('public');

        return $invoice->stream();
    }

    public function from(Contact $contact)
    {
        return new Party([
            'name' => 'Roosevelt Lloyd',
            'phone' => '(520) 318-9486',
            'custom_fields' => [
                'note' => 'IDDQD',
                'business id' => '365#GG',
            ],
        ]);
    }

    public function for(Contact $contact)
    {
        return new Party([
            'name' => 'Ashley Medina',
            'address' => 'The Green Street 12',
            'code' => '#22663214',
            'custom_fields' => [
                'order number' => '> 654321 <',
            ],
        ]);
    }

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

    public function products()
    {
        return [
            (new InvoiceItem())->title('Service 1')->pricePerUnit(47.79)->quantity(2)->discount(10),
            (new InvoiceItem())->title('Service 2')->pricePerUnit(71.96)->quantity(2),
            (new InvoiceItem())->title('Service 3')->pricePerUnit(4.56),
            (new InvoiceItem())->title('Service 4')->pricePerUnit(87.51)->quantity(7)->discount(4),
            (new InvoiceItem())->title('Service 5')->pricePerUnit(71.09)->quantity(7)->discountByPercent(9),
            (new InvoiceItem())->title('Service 6')->pricePerUnit(76.32)->quantity(9),
            (new InvoiceItem())->title('Service 7')->pricePerUnit(58.18)->quantity(3)->discount(3),
            (new InvoiceItem())->title('Service 8')->pricePerUnit(42.99)->quantity(4)->discountByPercent(3),
            (new InvoiceItem())->title('Service 9')->pricePerUnit(33.24)->quantity(6),
            (new InvoiceItem())->title('Service 11')->pricePerUnit(97.45)->quantity(2),
            (new InvoiceItem())->title('Service 12')->pricePerUnit(92.82),
            (new InvoiceItem())->title('Service 13')->pricePerUnit(12.98),
            (new InvoiceItem())->title('Service 14')->pricePerUnit(160),
            (new InvoiceItem())->title('Service 15')->pricePerUnit(62.21)->discountByPercent(5),
            (new InvoiceItem())->title('Service 16')->pricePerUnit(2.80),
            (new InvoiceItem())->title('Service 17')->pricePerUnit(56.21),
            (new InvoiceItem())->title('Service 18')->pricePerUnit(66.81)->discountByPercent(8),
            (new InvoiceItem())->title('Service 19')->pricePerUnit(76.37),
            (new InvoiceItem())->title('Service 20')->pricePerUnit(55.80),
        ];
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
