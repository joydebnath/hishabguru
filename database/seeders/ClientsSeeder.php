<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Address;
use App\Models\Contact;
use App\Models\ContactDetail;

class ClientsSeeder extends Seeder
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
                'type' => \App\Enums\Contact\ContactType::CLIENT
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
                'address_type' => \App\Enums\Address\AddressType::HOME
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
        }
    }
}
