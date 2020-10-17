<?php

namespace App\Http\Resources\Setting;

use App\Enums\Contact\ContactDetailsType;
use App\Enums\User\UserDetailsType;
use App\Http\Resources\Contact\Address;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $jobTitle = collect($this->details)->firstWhere('key', UserDetailsType::JOB_TITLE);
        $phone = collect($this->details)->firstWhere('key', ContactDetailsType::MOBILE);
        return [
            'personal_details' => [
                'job_title' => collect($jobTitle)->get('value', null)
            ],
            'contact_details' => [
                'address' => collect($this->addresses)->isNotEmpty() ? new Address($this->addresses) : [],
                'phone' => collect($phone)->get('value', null)
            ],
        ];
    }
}
