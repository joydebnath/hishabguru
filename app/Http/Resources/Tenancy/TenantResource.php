<?php

namespace App\Http\Resources\Tenancy;

use App\Http\Resources\Business\AddressCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class TenantResource extends JsonResource
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
            'id' => $this->id,
            'business_type' => $this->business_type,
            'default_country' => $this->country_of_operation,
            'default_currency' => $this->currency_of_operation,
            'addresses' => new AddressCollection($this->addresses) ,
        ];
    }
}
