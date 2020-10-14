<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $guarded = ['id'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_images', 'image_id', 'product_id')
            ->withPivot('sort_order')->withTimestamps();
    }

    public function imageable()
    {
        return $this->morphTo();
    }
}
