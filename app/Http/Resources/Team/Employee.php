<?php

namespace App\Http\Resources\Team;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Employee extends JsonResource
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
            'system_role' => null,
            'mobile' => collect($this->mobiles)->isNotEmpty() ? $this->mobiles->first()->value : null,
            'email' => collect($this->emails)->isNotEmpty() ? $this->emails->first()->value : null,
            'job_title' => collect($this->jobTitle)->isNotEmpty() ? collect($this->jobTitle)->first()->value : null,
            'currently_working' => collect($this->currentlyWorking)->isNotEmpty() ? ucfirst(collect($this->currentlyWorking)->first()->value) : null,
            'formatted_address' => $address ? $address->address_line_1 . ', ' . $address->city . ', ' . $address->postcode : '',
        ];
    }
}
