<?php

namespace App\Enums\Business;

final class QuotationStatus
{
    const DRAFT = 'draft';
    const OPEN = 'open';
    const AWAITING_APPROVAL = 'awaiting-approval';
    const SENT = 'sent';
    const DECLINED = 'declined';
    const ACCEPTED = 'accepted';
    const ORDERED = 'ordered';
    const INVOICED = 'invoiced';
}
