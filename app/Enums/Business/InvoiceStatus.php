<?php

namespace App\Enums\Business;

final class InvoiceStatus
{
    const DRAFT = 'draft';
    const PAID = 'paid';
    const PARTIALLY_PAID = 'partially-paid';
    const AWAITING_APPROVAL = 'awaiting-approval';
    const AWAITING_PAYMENT = 'awaiting-payment';
}
