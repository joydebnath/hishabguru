<?php


namespace App\Services\Setting;

use App\Http\Resources\Setting\PersonalDetails as PersonalDetailsResource;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PersonalDetails implements SettingUpdatable
{

    public function update($tenantId, $request)
    {
        $storable = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        $user->update($storable);

        $this->updateDetails($request, $user, $tenantId);

        return new PersonalDetailsResource($user->fresh('details'));
    }

    private function updateDetails(Request $request, $user, $tenantId): void
    {
        $details = $request->validate([
            'job_title' => 'nullable|string|max:255',
        ]);

        foreach ($details as $key => $detail) {
            if ($detail) {
                UserDetail::updateOrCreate(
                    ['user_id' => $user->id, 'tenant_id' => $tenantId, 'key' => $key],
                    ['value' => $detail]
                );
            } else {
                UserDetail::where(
                    ['user_id' => $user->id, 'tenant_id' => $tenantId, 'key' => $key]
                )->delete();
            }
        }
    }
}
