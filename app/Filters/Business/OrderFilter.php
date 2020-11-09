<?php

namespace App\Filters\Business;

use App\Filters\QueryFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class OrderFilter extends QueryFilter
{
    public function tenant_id(int $id)
    {
        $this->builder->where('tenant_id', $id);
    }

    public function search(string $search)
    {
        $this->builder->where(function ($query) use ($search) {
            $query
                ->where('order_number', 'like', '%' . $search . '%')
                ->orWhere('reference_number', 'like', '%' . $search . '%');
        })->orWhereHas('contact', function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }

    public function statuses(array $statuses)
    {
        $this->builder->whereIn('status', $statuses);
    }

    public function create_date(array $dates)
    {
        $start = Carbon::createFromFormat('d/m/Y', array_shift($dates))->startOfDay();
        $end = Carbon::createFromFormat('d/m/Y', array_shift($dates))->endOfDay();
        $this->builder->whereBetween('create_date', [$start, $end]);
    }

    public function delivery_date(array $dates)
    {
        $start = Carbon::createFromFormat('d/m/Y', array_shift($dates))->startOfDay();
        $end = Carbon::createFromFormat('d/m/Y', array_shift($dates))->endOfDay();
        $this->builder->whereBetween('delivery_date', [$start, $end]);
    }

    public function amount(string $amountRange)
    {
        $amounts = json_decode($amountRange, true);
        $conditions = [];
        if ($amounts['from']) {
            array_push($conditions, ['total_amount', '>=', $amounts['from']]);
        }
        if ($amounts['to']) {
            array_push($conditions, ['total_amount', '<=', $amounts['to']]);
        }
        if (!empty($conditions)) {
            $this->builder->where($conditions);
        }
    }

    public function sort(string $sortFields)
    {
        $sort = json_decode($sortFields, true);
        $this->builder->orderBy($sort['by'], $sort['order']);
    }
}
