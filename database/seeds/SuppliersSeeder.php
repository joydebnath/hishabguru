<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Address;
use App\Models\Contact;
use App\Models\ContactDetail;

class SuppliersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 1; $i < 51; $i++) {
            $contact = Contact::create([
                'name' => $faker->name,
                'tenant_id' => 2,
                'note' => $faker->paragraph,
                'type' => \App\Enums\Contact\ContactType::SUPPLIER
            ]);

            Address::create([
                'addressable_type' => \App\Enums\Address\Addressable::CONTACT,
                'addressable_id' => $contact->id,
                'address_line_1' => $faker->streetAddress,
                'address_line_2' => '',
                'city' => $faker->city,
                'postcode' => $faker->postcode,
                'state' => $faker->state,
                'country' => $faker->country,
                'address_type' => \App\Enums\Address\AddressType::HQ
            ]);

            ContactDetail::create([
                'contact_id' => $contact->id,
                'key' => \App\Enums\Contact\ContactDetailsType::MOBILE,
                'value' => $faker->phoneNumber
            ]);

            ContactDetail::create([
                'contact_id' => $contact->id,
                'key' => \App\Enums\Contact\ContactDetailsType::EMAIL,
                'value' => $faker->email
            ]);

            $primaryContact = Contact::create([
                'name' => $faker->name,
                'tenant_id' => 2,
                'note' => $faker->paragraph,
                'type' => \App\Enums\Contact\ContactType::SUPPLIER_PRIMARY_PERSON
            ]);

            ContactDetail::create([
                'contact_id' => $primaryContact->id,
                'key' => \App\Enums\Contact\ContactDetailsType::MOBILE,
                'value' => $faker->phoneNumber
            ]);

            ContactDetail::create([
                'contact_id' => $primaryContact->id,
                'key' => \App\Enums\Contact\ContactDetailsType::EMAIL,
                'value' => $faker->email
            ]);

            $contact->child_contacts()->attach($primaryContact->id);
        }
    }
}
