<?php


namespace App\Services\Setting;

use Illuminate\Http\Request;

interface SettingUpdatable
{
    public function update($tenantId, Request $request);
}
