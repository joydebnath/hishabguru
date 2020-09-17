<?php

namespace App\Http\Resources\Contact;

use App\Enums\Address\AddressType;
use App\Enums\Contact\ContactDetailsType;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $address = $this->getHomeAddress();
        $email = $this->getEmailAddress();
        $mobile = $this->getMobileNumber();
        $phone = $this->getPhoneNumber();

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
        ];
    }

    private function getHomeAddress()
    {
        return collect($this->addresses)
            ->where('address_type', '=', AddressType::HOME)
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
}
