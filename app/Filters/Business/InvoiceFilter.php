<?php

namespace App\Filters\Business;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class InvoiceFilter extends QueryFilter
{
    public function tenant_id(int $id)
    {
        $this->builder->where('tenant_id', $id);
    }

    public function search(string $search)
    {
        $this->builder->where(function ($query) use ($search) {
            $query
                ->where('invoice_number', 'like', '%' . $search . '%')
                ->orWhere('reference_number', 'like', '%' . $search . '%');
        })->orWhereHas('contact', function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }
}
