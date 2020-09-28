<?php

namespace App\Models;

use App\Enums\Address\Addressable;
use Illuminate\Database\Eloquent\Model;

class InventorySite extends Model
{
    protected $guarded = ['id'];

    public function address()
    {
        return $this->hasOne(Address::class,'addressable_id')->where('addressable_type', Addressable::INVENTORY_SITE);
    }
}
