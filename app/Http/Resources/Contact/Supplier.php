<?php

namespace App\Http\Resources\Contact;

use Illuminate\Http\Resources\Json\JsonResource;

class Supplier extends JsonResource
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
        $dueAmount = collect(collect($this->creditors)->first())->get('open_balance', null);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'mobile' => $this->mobiles->first() ? $this->mobiles->first()->value : '',
            'email' => $this->emails->first() ? $this->emails->first()->value : '',
            'you_owe_them' => $dueAmount,
            'you_owe_them_formatted' => $dueAmount ? number_format($dueAmount, 2) : null,
            'formatted_address' => $address ? $address->address_line_1 . ', ' . $address->city . ', ' . $address->postcode : '',
        ];
    }
}
