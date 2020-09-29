<?php

namespace App\Services\User;

use Illuminate\Support\Facades\Cache;

class SystemUserCacheService
{
    protected $cacheTTL = 600; // 10 min

    public function getUserRoles($user)
    {
        return cache()->remember($this->generateCacheKey($user), $this->cacheTTL, function () use ($user) {
            $user->load('tenants.user_roles');
            $tenantRoles = [];
            foreach ($user->tenants as $tenant) {
                $tenantRoles[$tenant->id] = $tenant;
            }
            return $tenantRoles;
        });
    }

    public function generateCacheKey($user)
    {
        return 'user:' . $user->id . ':roles';
    }

    public function flushCache($user)
    {
        Cache::forget($this->generateCacheKey($user));
    }
}
