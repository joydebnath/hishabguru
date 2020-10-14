<?php

namespace App\Http\Controllers\Tenancy;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tenancy\TenantResource;
use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index()
    {
        abort(405);
    }

    public function store(Request $request)
    {
        abort(405);
    }

    public function show(Tenant $tenant)
    {
        return new TenantResource($tenant->load('addresses'));
    }

    public function update(Request $request, Tenant $tenant)
    {
        abort(405);
    }

    public function destroy(Tenant $tenant)
    {
        abort(405);
    }
}
