<?php

namespace App\Models;

use App\Enums\Address\Addressable;
use App\Enums\Contact\ContactDetailsType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Tenant extends Model
{
    protected $guarded = ['id'];

    public function product_categories()
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'addressable_id')->where('addressable_type', Addressable::TENANT);
    }

    public function details()
    {
        return $this->hasMany(TenantDetail::class);
    }

    public function emails()
    {
        return $this->details()->where('key', ContactDetailsType::EMAIL);
    }

    public function mobiles()
    {
        return $this->details()->where('key', ContactDetailsType::MOBILE);
    }

    public function phones()
    {
        return $this->details()->where('key', ContactDetailsType::PHONE);
    }

    public function website()
    {
        return $this->details()->where('key', ContactDetailsType::WEBSITE);
    }

    public function user_roles()
    {
        return $this->belongsToMany(Role::class, 'tenant_users');
    }

    public function imageable(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
