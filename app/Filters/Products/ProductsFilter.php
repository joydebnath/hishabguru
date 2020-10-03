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

    public function sellable()
    {
        $this->builder->where('is_sellable', '=', true);
    }

    public function purchasable()
    {
        $this->builder->where('is_purchasable', '=', true);
    }
}
