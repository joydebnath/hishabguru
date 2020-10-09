<?php

namespace App\Http\Resources\Team;

use App\Enums\Address\AddressType;
use App\Enums\Contact\ContactDetailsType;
use App\Enums\EmployeeDetailsType;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeFullResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $address = $this->getHomeAddress();
        $email = $this->getEmailAddress();
        $mobile = $this->getMobileNumber();
        $phone = $this->getPhoneNumber();
        $employeeId = $this->getEmployeeID();
        $jobTitle = $this->getJobTitle();
        $currentlyWorking = $this->getCurrentlyWorking();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'mobile' => $mobile ? $mobile->value : null,
            'phone' => $phone ? $phone->value : null,
            'email' => $email ? $email->value : null,
            'employee_id' => $employeeId ? $employeeId->value : null,
            'job_title' => $jobTitle ? $jobTitle->value : null,
            'currently_working' => $currentlyWorking ? $currentlyWorking->value : null,
            'address_line_1' => $address ? $address->address_line_1 : null,
            'address_line_2' => $address ? $address->address_line_2 : null,
            'address_type' => $address ? $address->address_type : null,
            'city' => $address ? $address->city : null,
            'postcode' => $address ? $address->postcode : null,
            'state' => $address ? $address->state : null,
            'country' => $address ? $address->country : null,
            'note' => $this->note
        ];
    }

    private function getHomeAddress()
    {
        return collect($this->addresses)
            ->where('address_type', '=', AddressType::HOME)
            ->first();
    }

    private function getMobileNumber()
    {
        return collect($this->contact_details)
            ->where('key', '=', ContactDetailsType::MOBILE)
            ->first();
    }

    private function getPhoneNumber()
    {
        return collect($this->contact_details)
            ->where('key', '=', ContactDetailsType::PHONE)
            ->first();
    }

    private function getEmailAddress()
    {
        return collect($this->contact_details)
            ->where('key', '=', ContactDetailsType::EMAIL)
            ->first();
    }

    private function getEmployeeID()
    {
        return collect($this->contact_details)
            ->where('key', '=', EmployeeDetailsType::EMPLOYEE_ID)
            ->first();
    }

    private function getJobTitle()
    {
        return collect($this->contact_details)
            ->where('key', '=', EmployeeDetailsType::JOB_TITLE)
            ->first();
    }

    private function getCurrentlyWorking()
    {
        return collect($this->contact_details)
            ->where('key', '=', EmployeeDetailsType::CURRENTLY_WORKING)
            ->first();
    }
}
