<?php

namespace App\Filters\Products;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class ProductsFilter extends QueryFilter
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
                ->orWhere('code', 'like', '%' . $search . '%');
        });
    }

    public function is_sellable(string $sellable)
    {
        $this->builder->where('is_sellable', $sellable === 'true');
    }

    public function is_purchasable(string $purchasable)
    {
        $this->builder->where('is_purchasable', $purchasable === 'true');
    }

    public function statuses(array $statuses)
    {
        $this->builder->whereIn('status', $statuses);
    }

    public function category($categoryId)
    {
        $this->builder->where('product_category_id', $categoryId);
    }

    public function buying_unit_cost(string $amountRange)
    {
        $amounts = json_decode($amountRange, true);
        $conditions = [];
        if ($amounts['from']) {
            array_push($conditions, ['buying_unit_cost', '>=', $amounts['from']]);
        }
        if ($amounts['to']) {
            array_push($conditions, ['buying_unit_cost', '<=', $amounts['to']]);
        }
        if (!empty($conditions)) {
            $this->builder->where($conditions);
        }
    }

    public function selling_unit_cost(string $amountRange)
    {
        $amounts = json_decode($amountRange, true);
        $conditions = [];
        if ($amounts['from']) {
            array_push($conditions, ['selling_unit_price', '>=', $amounts['from']]);
        }
        if ($amounts['to']) {
            array_push($conditions, ['selling_unit_price', '<=', $amounts['to']]);
        }
        if (!empty($conditions)) {
            $this->builder->where($conditions);
        }
    }

    public function quantity(string $range)
    {
        $quantity = json_decode($range, true);
        $conditions = [];
        if ($quantity['from']) {
            array_push($conditions, ['quantity', '>=', $quantity['from']]);
        }
        if ($quantity['to']) {
            array_push($conditions, ['quantity', '<=', $quantity['to']]);
        }
        if (!empty($conditions)) {
            $this->builder->where($conditions);
        }
    }
}
