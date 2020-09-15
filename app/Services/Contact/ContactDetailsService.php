<?php

namespace App\Services\Contact;

use App\Models\ContactDetail;
use Illuminate\Support\Facades\DB;

class ContactDetailsService
{
    public function create($contactId, $storeable)
    {
        if (isset($storeable['mobile'])) {
            ContactDetail::create([
                'contact_id' => $contactId,
                'key' => 'mobile',
                'value' => $storeable['mobile']
            ]);
        }
        if (isset($storeable['phone'])) {
            ContactDetail::create([
                'contact_id' => $contactId,
                'key' => 'phone',
                'value' => $storeable['phone']
            ]);
        }
        if (isset($storeable['email'])) {
            ContactDetail::create([
                'contact_id' => $contactId,
                'key' => 'email',
                'value' => $storeable['email']
            ]);
        }
    }

    public function update($contactId, $updateable)
    {
        if (isset($updateable['mobile'])) {
            ContactDetail::updateOrCreate(
                ['contact_id' => $contactId, 'key' => 'mobile'],
                ['value' => $updateable['mobile']]);
        }
        if (isset($updateable['phone'])) {
            ContactDetail::updateOrCreate(
                ['contact_id' => $contactId, 'key' => 'phone'],
                ['value' => $updateable['phone']]
            );
        }
        if (isset($updateable['email'])) {
            ContactDetail::updateOrCreate(
                ['contact_id' => $contactId, 'key' => 'email'],
                ['value' => $updateable['email']]
            );
        }
    }
}
