<?php

namespace App\Traits;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * @param Builder $builder
     * @param QueryFilter $filter
     */
    public function scopeFilter(Builder $builder, QueryFilter $filter)
    {
        if($this->indexConfigurator){
            $index = $this->search(request()->search);
            $builder->when($index && $index->count(), function($query) use ($index) {
                $query->whereIn('id', $index->get()->pluck('id'));
            });
        }
        return $filter->apply($builder);
    }
}
