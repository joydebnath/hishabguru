<?php

namespace App\Services\Tenant;

class ValidateTenantService
{
    public function setupCompleted($tenant)
    {
        if ($tenant) {
            return $tenant->setup_complete_flag;
        }
        return false;
    }
}
