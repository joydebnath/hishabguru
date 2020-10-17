<?php

namespace App\Http\Resources\Setting;

use App\Enums\User\UserDetailsType;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonalDetails extends JsonResource
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
        return [
            'user' => [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
            ],
            'personal_details' => [
                'job_title' => collect($jobTitle)->get('value', null)
            ],
        ];
    }
}
