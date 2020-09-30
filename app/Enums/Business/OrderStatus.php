<?php

namespace App\Enums\Business;

final class OrderStatus
{
    const COMPLETED =   'completed';
    const DISPATCHED =   'dispatched';
    const PENDING = 'pending';
    const CONFIRMED = 'confirmed';
    const PARTIAL_PAYMENT_REQUIRED = 'partial-payment-required';
    const FULL_PAYMENT_REQUIRED = 'full-payment-required';
}
