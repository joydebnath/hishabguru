<?php

namespace App\Http\Resources\Contact;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierLookup extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $address = collect($this->addresses)->first();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'mobile' => $this->mobiles->first() ? $this->mobiles->first()->value : null,
            'email' => $this->emails->first() ? $this->emails->first()->value : null,
            'formatted_address' => $address ? $address->address_line_1 . ', ' . $address->city : null,
        ];
    }
}
