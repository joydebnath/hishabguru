<?php

namespace App\Filters\Expense;
use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class OtherExpenseFilter extends QueryFilter {
    public function tenant_id(int $id)
    {
        $this->builder->where('tenant_id', $id);
    }

    public function search(string $search)
    {
        $this->builder->where(function ($query) use ($search) {
            $query
                ->where('expense_number', 'like', '%' . $search . '%')
                ->orWhere('reference_number', 'like', '%' . $search . '%');
        });
    }
}
