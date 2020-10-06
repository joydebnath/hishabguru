<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class OtherExpense extends Model
{
    use Filterable;

    protected $table = 'other_expenses';
    protected $guarded = ['id'];

    public function items(): HasMany
    {
        return $this->hasMany(OtherExpenseItem::class);
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
}
