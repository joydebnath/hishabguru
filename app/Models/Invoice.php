<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Invoice extends Model
{
    protected $guarded = ['id'];

    public function payable(): MorphMany
    {
        return $this->morphMany(PaymentHistory::class, 'payable');
    }

}
