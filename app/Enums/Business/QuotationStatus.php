<?php

namespace App\Enums\Business;

final class QuotationStatus
{
    const DRAFT = 'draft';
    const SAVE = 'save';
    const SAVE_FOR_APPROVAL = 'save-for-approval';
    const SENT = 'sent';
    const DECLINED = 'declined';
    const ACCEPTED = 'accepted';
    const ORDERED = 'ordered';
    const INVOICED = 'invoiced';
}
