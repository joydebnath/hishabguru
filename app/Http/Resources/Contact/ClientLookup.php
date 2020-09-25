<?php

namespace App\Http\Resources\Contact;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientLookup extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $address = collect($this->addresses)->first();
        $mobile = $this->mobiles ? $this->mobiles->first() : null;
        $email = $this->emails ? $this->emails->first() : null;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'mobile' => $mobile ? $mobile->value : null,
            'm_contact_details_id' => $mobile ? $mobile->id : null,
            'email' => $email ? $email->value : null,
            'address' => $address ? $this->fullAddress($address) : null,
            'address_id' => $address ? $address->id : null,
            'formatted_address' => $address ? $this->formatedAddress($address) : null,
        ];
    }

    private function fullAddress($address)
    {
        return $address->address_line_1 . ' ' . $address->address_line_2 . ', ' . $address->city . ', ' . $address->postcode;
    }

    private function formatedAddress($address)
    {
        return $address->address_line_1 . ', ' . $address->city;
    }
}
