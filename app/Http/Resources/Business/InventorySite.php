<?php

namespace App\Http\Resources\Business;

use Illuminate\Http\Resources\Json\JsonResource;

class InventorySite extends JsonResource
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
            'name' => $this->name,
            'formatted_address' => $this->address ? $this->formattedAddress($this->address) : null,
            'address_type' => $this->address ? $this->address->address_type : null
        ];
    }

    private function formattedAddress($address)
    {
        return $address->address_line_1 . ', ' . $address->city . ' ' . $address->postcode;
    }
}
