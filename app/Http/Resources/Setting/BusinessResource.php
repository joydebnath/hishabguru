<?php

namespace App\Http\Resources\Setting;

use App\Enums\Address\AddressType;
use App\Http\Resources\Contact\Address;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'logo' => $this->imageable ? '/'.collect($this->imageable)->get('source') : '',
            'business_details' => [
                'name' => $this->name,
                'business_type' => $this->business_type,
                'tax_file_number' => $this->tax_file_number,
                'description' => $this->description,
            ],
            'contact_details' => [
                'headquarter' => $this->getHQ(),
                'postal' => $this->getPostal(),
                'phone' => $this->phones->first() ? $this->phones->first()->value : null,
                'email' => $this->emails->first() ? $this->emails->first()->value : null,
                'website' => $this->websites->first() ? $this->websites->first()->value : null,
            ],
            'operation_details' => [
                'country' => $this->country_of_operation,
                'currency' => $this->currency_of_operation,
            ],
        ];
    }

    private function getHQ()
    {
        $hq = $this->addresses->firstWhere('address_type', AddressType::HQ);
        return $hq == null ? [] : new Address($hq);
    }

    private function getPostal()
    {
        $postal = $this->addresses->firstWhere('address_type', AddressType::POSTAL);
        return $postal === null ? [] : new Address($postal);
    }
}
