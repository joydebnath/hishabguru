<?php

namespace App\Filters\Products;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class ProductCategoriesFilter extends QueryFilter
{
    public function tenant_id(int $id)
    {
        $this->builder->where('tenant_id', $id);
    }

    public function search(string $search)
    {
        $this->builder->where('name', 'like', '%' . $search . '%');
    }
}
