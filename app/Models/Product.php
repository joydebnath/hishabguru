<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Filterable;

    protected $guarded = ['id'];

    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'product_images', 'product_id', 'image_id')
            ->withPivot('sort_order')->withTimestamps();
    }

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'invoice_products', 'product_id', 'invoice_id')
            ->withPivot('quantity', 'total', 'discount', 'tax_rate');
    }

    public function bills()
    {
        return $this->belongsToMany(Bill::class, 'bill_items', 'product_id', 'bill_id')
            ->withPivot('quantity', 'total', 'buying_unit_cost', 'tax_rate');
    }
}
