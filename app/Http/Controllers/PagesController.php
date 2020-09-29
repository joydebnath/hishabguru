<?php

namespace App\Http\Controllers;

use App\Services\Tenant\ValidateTenantService;
use App\Services\User\CheckUserRolesService;
use App\Services\User\SystemUserCacheService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class PagesController extends Controller
{
    protected $userCache, $checkUserRoles, $tenantValidation;

    public function __construct(SystemUserCacheService $cacheService, CheckUserRolesService $checkUserRoles, ValidateTenantService $tenantValidation)
    {
        $this->userCache = $cacheService;
        $this->checkUserRoles = $checkUserRoles;
        $this->tenantValidation = $tenantValidation;
    }

    public function index()
    {
        try {
            if ($this->userHasSetupTenancy()) {
                return redirect('/init');
            }
            return view('spa');
        } catch (\Exception $exception) {
            return redirect('/is-void-account');
        }
    }

    public function userHasSetupTenancy()
    {
        $userRoles = $this->userCache->getUserRoles(Auth::user());
        $currentTenantId = array_key_first($userRoles);

        if ($currentTenantId === null) {
            throw new \Exception('User has no tenancy');
        }

        $userIsAdmin = $this->checkUserRoles->isTenantAdmin($userRoles, $currentTenantId);

        if (!$userIsAdmin) {
            return true;
        }

        return !$this->tenantValidation->setupCompleted($userRoles[$currentTenantId]);
    }
}
