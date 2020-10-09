<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function inventories()
    {
        return $this->belongsToMany(InventorySite::class, 'inventory_products_stock', 'product_id', 'inventory_site_id')
            ->withPivot('total_stock', 'reserved_stock', 'remaining_stock')->withTimestamps();
    }
}
