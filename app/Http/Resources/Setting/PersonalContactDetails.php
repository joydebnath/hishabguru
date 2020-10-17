<?php

namespace App\Http\Resources\Setting;

use App\Enums\Contact\ContactDetailsType;
use App\Http\Resources\Contact\Address;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonalContactDetails extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $phone = collect($this->details)->firstWhere('key', ContactDetailsType::PHONE);
        $addresses = collect($this->addresses);
        return [
            'contact_details' => [
                'address' => $addresses->isNotEmpty() ? new Address($addresses->first()) : [],
                'phone' => collect($phone)->get('value', null)
            ],
        ];
    }
}
