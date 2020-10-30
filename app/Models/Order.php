<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use Filterable;

    protected $guarded = ['id'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_products', 'order_id', 'product_id')
            ->withPivot('quantity', 'discount', 'tax_rate', 'total')
            ->withTimestamps();
    }

    public function invoices(): BelongsToMany
    {
        return $this->belongsToMany(Invoice::class, 'copy_references', 'copy_from_id', 'copy_to_id')
            ->wherePivot('copy_from_type', '=', 'orders')
            ->wherePivot('copy_to_type', '=', 'invoices')
            ->withPivot('copy_from_type', 'copy_to_type')
            ->withTimestamps();
    }

    public function quotations()
    {
        return $this->belongsToMany(Quotation::class, 'copy_references', 'copy_to_id', 'copy_from_id')
            ->wherePivot('copy_from_type', '=', 'quotations')
            ->wherePivot('copy_to_type', '=', 'orders');
    }

    public function quotation_invoices()
    {
        return $this->quotations()->with('invoices');
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

    public function deliveryDetails(): HasOne
    {
        return $this->hasOne(OrderDeliveryDetails::class);
    }

    public function totalBuyingCost()
    {
        return collect($this->products)->sum(function ($product) {
            return $product->buying_unit_cost * $product->pivot->quantity;
        });
    }
}
