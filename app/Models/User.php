<?php

namespace App\Models;

use App\Enums\Address\Addressable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'tenant_users')->withPivot('tenant_id');
    }

    public function admin_roles()
    {
        return $this->roles()->where('slug', 'admin');
    }

    public function tenants()
    {
        return $this->belongsToMany(Tenant::class, 'tenant_users')->withPivot('role_id')->withTimestamps();
    }

    public function current_tenant()
    {
        return $this->belongsTo(Tenant::class, 'current_tenant_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'addressable_id')->where('addressable_type', Addressable::USER);
    }

    public function details()
    {
        return $this->hasMany(UserDetail::class);
    }
}
