<?php

namespace App\Services\User;

use App\Enums\System\UserRoles;

class CheckUserRolesService {

    public function isTenantAdmin($userRoles, $tenantId)
    {
        return $this->userRoleIs($userRoles, $tenantId,UserRoles::ADMIN) !== null;
    }

    private function userRoleIs($userRoles, $tenantId, $role)
    {
        $tenantUserRoles = $userRoles[$tenantId]->user_roles;
        return $tenantUserRoles->where('slug', UserRoles::ADMIN)->first();
    }
}
