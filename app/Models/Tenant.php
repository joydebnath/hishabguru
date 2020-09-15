<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $guarded = ['id'];

    public function product_categories()
    {
        return $this->hasMany(ProductCategory::class);
    }
}
