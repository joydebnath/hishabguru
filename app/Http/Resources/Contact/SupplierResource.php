<?php

namespace App\Http\Resources\Contact;

use App\Enums\Address\AddressType;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $address = $this->getAddress();
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

    private function getAddress()
    {
        return collect($this->addresses)
            ->where('address_type', '=', AddressType::HQ)
            ->first();
    }

    private function getMobileNumber()
    {
        return collect($this->contact_details)
            ->where('key', '=', 'mobile')
            ->first();
    }

    private function getPhoneNumber()
    {
        return collect($this->contact_details)
            ->where('key', '=', 'phone')
            ->first();
    }

    private function getEmailAddress()
    {
        return collect($this->contact_details)
            ->where('key', '=', 'email')
            ->first();
    }
}
