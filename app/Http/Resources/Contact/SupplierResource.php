<?php

namespace App\Http\Resources\Contact;

use App\Enums\Address\AddressType;
use App\Enums\Contact\ContactDetailsType;
use App\Enums\Contact\ContactType;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $address = $this->getAddress();
        $email = $this->getEmailAddress();
        $mobile = $this->getMobileNumber();
        $phone = $this->getPhoneNumber();
        $primaryContactPerson = $this->getPrimaryContactPerson();
        $primaryContactPersonContacts = $this->getPrimaryContactPersonContacts($primaryContactPerson);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'mobile' => $mobile ? $mobile->value : null,
            'phone' => $phone ? $phone->value : null,
            'email' => $email ? $email->value : null,
            'address_line_1' => $address ? $address->address_line_1 : null,
            'address_line_2' => $address ? $address->address_line_2 : null,
            'address_type' => $address ? $address->address_type : null,
            'city' => $address ? $address->city : null,
            'postcode' => $address ? $address->postcode : null,
            'state' => $address ? $address->state : null,
            'country' => $address ? $address->country : null,
            'note' => $this->note,
            'primary_contact_person_id' => $primaryContactPerson ? $primaryContactPerson->id : null,
            'primary_contact_person_name' => $primaryContactPerson ? $primaryContactPerson->name : null,
            'primary_contact_person_mobile' => $primaryContactPersonContacts['mobile'] ? $primaryContactPersonContacts ['mobile']->value : null,
            'primary_contact_person_phone' => $primaryContactPersonContacts['phone'] ? $primaryContactPersonContacts['phone']->value : null,
            'primary_contact_person_email' => $primaryContactPersonContacts['email'] ? $primaryContactPersonContacts['email']->value : null,
        ];
    }

    private function getAddress()
    {
        return collect($this->addresses)
            ->where('address_type', '=', AddressType::HQ)
            ->first();
    }

    private function getMobileNumber()
    {
        return collect($this->contact_details)
            ->where('key', '=', ContactDetailsType::MOBILE)
            ->first();
    }

    private function getPhoneNumber()
    {
        return collect($this->contact_details)
            ->where('key', '=', ContactDetailsType::PHONE)
            ->first();
    }

    private function getEmailAddress()
    {
        return collect($this->contact_details)
            ->where('key', '=', ContactDetailsType::EMAIL)
            ->first();
    }

    private function getPrimaryContactPerson()
    {
        return collect($this->child_contacts)
            ->where('type', '=', ContactType::SUPPLIER_PRIMARY_PERSON)
            ->first();
    }

    private function getPrimaryContactPersonContacts($primaryContactPerson)
    {
        return [
            'email' => isset($primaryContactPerson->contact_details) ?
                collect($primaryContactPerson->contact_details)
                    ->where('key', '=', ContactDetailsType::EMAIL)
                    ->first() : null,
            'phone' => isset($primaryContactPerson->contact_details) ?
                collect($primaryContactPerson->contact_details)
                    ->where('key', '=', ContactDetailsType::PHONE)
                    ->first() : null,
            'mobile' => isset($primaryContactPerson->contact_details) ?
                collect($primaryContactPerson->contact_details)
                    ->where('key', '=', ContactDetailsType::MOBILE)
                    ->first() : null
        ];
    }
}
