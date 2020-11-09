<?php

namespace App\Http\Resources\Contact;

use Carbon\Carbon;
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

        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_active' => $this->is_active,
            'created_at' => Carbon::parse($this->created_at)->format('d/m/y'),
            'mobile' => $this->mobiles->first() ? $this->mobiles->first()->value : '',
            'email' => $this->emails->first() ? $this->emails->first()->value : '',
            'you_owe_them' => $this->due_amount,
            'you_owe_them_formatted' => $this->due_amount ? number_format($this->due_amount, 2) : null,
            'formatted_address' => $address ? $address->address_line_1 . ', ' . $address->city . ', ' . $address->postcode : '',
        ];
    }
}
