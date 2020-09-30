<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tenancy\TenantResource;
use App\Http\Resources\User\TenancyCollection;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenancyController extends Controller
{
    public function store(Request $request)
    {
        try {
            Auth::user()->update(
                ['current_tenant_id' => $request->tenant_id]
            );
            return new TenantResource(
                Tenant::with('inventorySites.address')->find($request->tenant_id)
            );
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
