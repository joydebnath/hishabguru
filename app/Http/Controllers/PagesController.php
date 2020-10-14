<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Services\Tenant\ValidateTenantService;
use App\Services\User\CheckUserRolesService;
use App\Services\User\SystemUserCacheService;
use Illuminate\Support\Facades\Auth;
use Exception;

class PagesController extends Controller
{
    protected $userCache;

    public function __construct(SystemUserCacheService $cacheService)
    {
        $this->userCache = $cacheService;
    }

    public function index()
    {
        try {
            if ($this->userTenancyIsNotComplete()) {
                return redirect('/init?tid=' . base64_encode(Auth::user()->current_tenant_id));
            }

            return view('spa');
        } catch (\Exception $exception) {
            return redirect('/is-void-account');
        }
    }

    public function userTenancyIsNotComplete()
    {
        $user = Auth::user()->load('current_tenant');

        if (collect($user->current_tenant)->isEmpty()) {
            throw new Exception('User has no tenancy');
        }

        if (!$this->userIsAdminInCurrentTenancy($user)) {
            return false;
        }

        return $user->current_tenant->setup_complete_flag == false;
    }

    private function userIsAdminInCurrentTenancy($user)
    {
        return $user->admin_roles->where('pivot.tenant_id', $user->current_tenant_id)->first() !== null;
    }
}
