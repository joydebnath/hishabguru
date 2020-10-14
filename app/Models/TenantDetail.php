<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantDetail extends Model
{
    protected $table = 'tenant_details';
    protected $guarded = ['id'];
}
