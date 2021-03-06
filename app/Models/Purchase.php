<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Purchase extends Model
{
    use Filterable;

    protected $guarded = ['id'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'purchase_products', 'purchase_id', 'product_id')
            ->withTimestamps()->withPivot('quantity', 'discount', 'tax_rate', 'total', 'buying_unit_cost');
    }

    public function bills(): BelongsToMany
    {
        return $this->belongsToMany(Bill::class, 'copy_references', 'copy_from_id', 'copy_to_id')
            ->wherePivot('copy_from_type', '=', 'purchases')
            ->wherePivot('copy_to_type', '=', 'bills')
            ->withPivot('copy_from_type', 'copy_to_type')
            ->withTimestamps();
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function deliverySite(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'delivery_site_id');
    }

    public function totalBuyingCost()
    {
        return collect($this->products)->sum(function ($product) {
            return $product->buying_unit_cost * $product->pivot->quantity;
        });
    }
}
