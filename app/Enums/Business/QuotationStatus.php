<?php

namespace App\Enums\Business;

use BenSampo\Enum\Enum;

final class QuotationStatus extends Enum
{
    const DRAFT = 'draft';
    const SENT = 'sent';
    const DECLINED = 'declined';
    const ACCEPTED = 'accepted';
    const ORDERED = 'ordered';
    const INVOICED = 'invoiced';
}
