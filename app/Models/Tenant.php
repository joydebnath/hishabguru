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

    public function inventorySites()
    {
        return $this->hasMany(InventorySite::class);
    }

    public function user_roles()
    {
        return $this->belongsToMany(Role::class, 'tenant_users');
    }
}
