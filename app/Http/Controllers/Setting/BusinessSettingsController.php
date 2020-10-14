<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\Setting\BusinessResource;
use App\Models\Tenant;
use Illuminate\Http\Request;

class BusinessSettingsController extends Controller
{
    public function show($id)
    {
        try {
            $tenant = Tenant::with('addresses', 'imageable', 'emails', 'phones', 'websites')->find($id);
            return new BusinessResource($tenant);
        } catch (\Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $type = $request->type;
    }
}
