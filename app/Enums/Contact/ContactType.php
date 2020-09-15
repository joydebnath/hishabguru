<?php

namespace App\Enums\Contact;

use BenSampo\Enum\Enum;

final class ContactType extends Enum
{
    const CLIENT =   'client';
    const SUPPLIER =   'supplier';
    const SUPPLIER_PRIMARY_PERSON =   'supplier_primary_contact_person';
    const SUPPLIER_SECONDARY_PERSON =   'supplier_secondary_contact_person';
}
