<?php

namespace App\Filters\Payment;

use App\Filters\QueryFilter;

class PaymentHistoryFilter extends QueryFilter
{
    public function payable_type(string $type)
    {
        $this->builder->where('payable_type', $type);
    }

    public function payable_id(int $id)
    {
        $this->builder->where('payable_id', $id);
    }
}
