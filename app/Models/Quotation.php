<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Quotation extends Model
{
    use Filterable;

    protected $guarded = ['id'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'quotation_products', 'quotation_id', 'product_id')
            ->withPivot('quantity', 'discount', 'tax_rate', 'total')
            ->withTimestamps();
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'copy_references', 'copy_from_id', 'copy_to_id')
            ->wherePivot('copy_from_type', '=', 'quotations')
            ->wherePivot('copy_to_type', '=', 'orders')
            ->withPivot('copy_from_type', 'copy_to_type')
            ->withTimestamps();
    }

    public function invoices(): BelongsToMany
    {
        return $this->belongsToMany(Invoice::class, 'copy_references', 'copy_from_id', 'copy_to_id')
            ->wherePivot('copy_from_type', '=', 'quotations')
            ->wherePivot('copy_to_type', '=', 'invoices')
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

    public function totalBuyingCost()
    {
        return collect($this->products)->sum(function ($product) {
            return $product->buying_unit_cost * $product->pivot->quantity;
        });
    }
}
