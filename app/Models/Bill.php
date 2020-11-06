<?php

namespace App\Models;

use App\Enums\Status\PaymentStatus;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Bill extends Model
{
    use Filterable;

    protected $guarded = ['id'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'bill_items', 'bill_id', 'product_id')
            ->withTimestamps()->withPivot('quantity', 'description', 'tax_rate', 'total', 'buying_unit_cost');
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

    public function payable(): MorphMany
    {
        return $this->morphMany(PaymentHistory::class, 'payable');
    }

    public function scopeNotDrafts($query)
    {
        $query->where('status', PaymentStatus::PAID)->orWhere('status', PaymentStatus::DUE);
    }
}
