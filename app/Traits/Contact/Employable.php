<?php

namespace App\Traits\Contact;

use App\Enums\EmployeeDetailsType;

trait Employable
{
    public function jobTitle()
    {
        return $this->contact_details()->where('key', EmployeeDetailsType::JOB_TITLE)->limit(1);
    }

    public function employeeId()
    {
        return $this->contact_details()->where('key', EmployeeDetailsType::EMPLOYEE_ID)->limit(1);
    }

    public function currentlyWorking()
    {
        return $this->contact_details()->where('key', EmployeeDetailsType::JOB_TITLE)->limit(1);
    }
}
