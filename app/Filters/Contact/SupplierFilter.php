<?php

namespace App\Filters\Contact;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class SupplierFilter extends QueryFilter
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
        $isActiveStatuses = array_map(function ($value) {
            return $value === 'active';
        }, $statuses);

        $this->builder->whereIn('is_active', $isActiveStatuses);
    }

    public function due_amount(string $amountRange)
    {
        $amounts = json_decode($amountRange, true);
        $conditions = [];
        if ($amounts['from']) {
            array_push($conditions, ['open_balance', '>=', $amounts['from']]);
        }
        if ($amounts['to']) {
            array_push($conditions, ['open_balance', '<=', $amounts['to']]);
        }
        if (!empty($conditions)) {
            $this->builder->whereHas('creditors',function ($query) use ($conditions){
                $query->where($conditions);
            });
        }
    }
}
