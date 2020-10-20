<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use Filterable;

    protected $guarded = ['id'];
    protected $table = 'product_categories';

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
