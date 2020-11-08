<?php

namespace App\Filters\Team;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class EmployeeFilter extends QueryFilter
{
    public function tenant_id(int $id)
    {
        $this->builder->where('tenant_id', $id);
    }

    public function search(string $search)
    {
        $this->builder->where(function ($query) use ($search) {
            $query
                ->where('name', 'like', '%' . $search . '%')
                ->orWhereHas('contact_details', function ($query) use ($search) {
                    $query->where('value', 'like', '%' . $search . '%');
                })
                ->orWhereHas('addresses', function ($query) use ($search) {
                    $query->where('address_line_1', 'like', '%' . $search . '%');
                });
        });
    }

    public function statuses(array $statuses)
    {
        $this->builder->whereHas('currentlyWorking', function ($query) use ($statuses) {
            $query->whereIn('value', $statuses);
        });
    }
}
