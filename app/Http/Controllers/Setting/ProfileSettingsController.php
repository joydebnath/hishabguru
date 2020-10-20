<?php

namespace App\Http\Controllers\Setting;

use App\Enums\Address\AddressType;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setting\ProfileResource;
use App\Services\Setting\ProfileSettingFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileSettingsController extends Controller
{
    public function show($id)
    {
        try {
            return new ProfileResource(
                Auth::user()->load([
                    'details' => function ($query) use ($id) {
                        $query->where('tenant_id', $id)->orWhere('tenant_id', null);
                    },
                    'addresses' => function ($query) {
                        $query->where('address_type', AddressType::HOME);
                    }
                ])
            );
        } catch (\Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        return ProfileSettingFactory::getFactory($request->type)->update($id, $request);
    }
}
