<?php

namespace App\Enums\Business;

final class InvoiceStatus
{
    const DRAFT = 'draft';
    const DUE = 'due';
    const PAID = 'paid';
    const AWAITING_APPROVAL = 'awaiting-approval';
}
