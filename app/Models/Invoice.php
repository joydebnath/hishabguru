<?php

namespace App\Models;

use App\Enums\Status\PaymentStatus;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Invoice extends Model
{
    use Filterable;

    protected $guarded = ['id'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'invoice_products', 'invoice_id', 'product_id')
            ->withTimestamps()->withPivot('quantity', 'discount', 'tax_rate', 'total');
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
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

    public function scopeIsNotDraft($query)
    {
        $query->where('status', PaymentStatus::PAID)->orWhere('status', PaymentStatus::DUE);
    }

    public function scopeWithProductCategoryId($query)
    {
        return $query->addSelect([
            'product_id' => function ($query) {
                $query
                    ->from('invoice_products')
                    ->whereColumn('invoice_id', 'invoices.id')
                    ->select('product_id');
            },
            'product_category_id' => Product::select('product_category_id')
                ->whereColumn('product_id', 'products.id'),
            'product_category_name' => ProductCategory::select('name')
                ->whereColumn('product_category_id', 'product_categories.id')
        ]);
    }
}
