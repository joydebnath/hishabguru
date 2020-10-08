<?php

namespace App\Services\Contact;

use App\Models\ContactDetail;

class EmployeeDetailsService
{
    public function create($contactId, $storeable): void
    {
        if (isset($storeable['employee_id'])) {
            ContactDetail::create([
                'contact_id' => $contactId,
                'key' => 'employee_id',
                'value' => $storeable['employee_id']
            ]);
        }
        if (isset($storeable['job_title'])) {
            ContactDetail::create([
                'contact_id' => $contactId,
                'key' => 'job_title',
                'value' => $storeable['job_title']
            ]);
        }
        if (isset($storeable['currently_working'])) {
            ContactDetail::create([
                'contact_id' => $contactId,
                'key' => 'currently_working',
                'value' => $storeable['currently_working']
            ]);
        }
    }

    public function update($contactId, $updateable): void
    {
        if (isset($updateable['employee_id'])) {
            ContactDetail::updateOrCreate(
                ['contact_id' => $contactId, 'key' => 'employee_id'],
                ['value' => $updateable['employee_id']]);
        }
        if (isset($updateable['job_title'])) {
            ContactDetail::updateOrCreate(
                ['contact_id' => $contactId, 'key' => 'job_title'],
                ['value' => $updateable['job_title']]
            );
        }
        if (isset($updateable['currently_working'])) {
            ContactDetail::updateOrCreate(
                ['contact_id' => $contactId, 'key' => 'currently_working'],
                ['value' => $updateable['currently_working']]
            );
        }
    }
}
