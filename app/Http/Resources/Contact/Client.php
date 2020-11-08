<?php

namespace App\Http\Resources\Contact;

use Illuminate\Http\Resources\Json\JsonResource;

class Client extends JsonResource
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
        $dueAmount = collect(collect($this->debtors)->first())->get('open_balance', null);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_active' => $this->is_active,
            'mobile' => $this->mobiles->first() ? $this->mobiles->first()->value : null,
            'email' => $this->emails->first() ? $this->emails->first()->value : null,
            'they_owe_you' => $dueAmount,
            'they_owe_you_formatted' => $dueAmount ? number_format($dueAmount, 2) : null,
            'formatted_address' => $address ? $address->address_line_1 . ', ' . $address->city . ', ' . $address->postcode : '',
        ];
    }
}
