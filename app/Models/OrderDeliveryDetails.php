<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDeliveryDetails extends Model
{
    protected $table = 'order_delivery_details';
    protected $guarded = ['id'];

    public function order() : BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
