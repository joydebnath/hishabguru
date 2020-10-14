<?php

namespace App\Http\Resources\Setting;

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
            'logo' => collect($this->imageable)->get('source', ''),
            'business_details' => [
                'name' => $this->name,
                'business_type' => $this->business_type,
                'tax_file_number' => $this->tax_file_number,
                'description' => $this->description,
            ],
            'contact_details' => [
                'headquarter' => $this->getHQ(),
                'postal' => $this->getPostal(),
                'phone' => '',
                'email' => '',
                'website' => '',
            ],
            'operation_details' => [
                'country' => $this->country_of_operation,
                'currency' => $this->currency_of_operation,
            ],
        ];
    }

    private function getHQ()
    {
        $hq = $this->addresses->firstWhere('address_type', 'headquarter');
        return $hq == null ? [] : new Address($hq);
    }

    private function getPostal()
    {
        $postal = $this->addresses->firstWhere('address_type', 'postal')->first();
        return $postal === null ? [] : new Address($postal);
    }
}
