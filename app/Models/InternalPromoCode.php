<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class InternalPromoCode extends Model
{
    protected $table = 'internal_promo_code';
    protected $guarded = ['id'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'internal_promo_code_users','promo_code_id','user_id');
    }
}
