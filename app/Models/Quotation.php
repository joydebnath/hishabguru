<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
class Quotation extends Model
{
    use Filterable;

    protected $guarded = ['id'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'quotation_products', 'quotation_id', 'product_id')
            ->withTimestamps()->withPivot('quantity', 'discount', 'tax_rate', 'total');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function totalBuyingCost()
    {
        return collect($this->products)->sum(function ($product){
            return $product->buying_unit_cost * $product->pivot->quantity;
        });
    }
}
