<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    use Filterable;

    protected $table = 'payment_histories';
    protected $guarded = ['id'];

    public function payable()
    {
        return $this->morphTo();
    }
}
