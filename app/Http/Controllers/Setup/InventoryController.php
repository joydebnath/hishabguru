<?php

namespace App\Http\Controllers\Setup;

use App\Enums\Address\Addressable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\InventoryRequest;
use App\Models\Tenant;
use App\Services\Contact\AddressService;
use App\Services\Inventory\InventoryService;
use App\Services\User\SystemUserCacheService;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    protected $inventoryService, $addressService;

    public function __construct(InventoryService $inventoryService, AddressService $addressService)
    {
        $this->inventoryService = $inventoryService;
        $this->addressService = $addressService;
    }

    public function create()
    {
        $tenancies = Auth::user()->tenants;
        $tenant = collect($tenancies)->first();
        if ($tenant) {
            return view('auth.setup-inventory', compact('tenant'));
        }
        return view('auth.create-new-tenancy');
    }

    public function store(InventoryRequest $request)
    {
        try {
            $storable = $this->getAddressStoreable($request);
            $site = $this->inventoryService->create([
                'name' => $request->name,
                'description' => $request->get('description', null),
            ], $request->tenant_id);

            $this->addressService->create($site->id, Addressable::INVENTORY_SITE, $storable);
            $this->tenantSetupCompleted($storable['tenant_id']);

            (new SystemUserCacheService())->flushCache(Auth::user());

            return redirect('/@/dashboard');
        } catch (\Exception $exception) {
            return redirect('/');
        }
    }

    /**
     * @param InventoryRequest $request
     * @return array
     */
    private function getAddressStoreable(InventoryRequest $request): array
    {
        $fillable = $request->validated();
        unset($fillable['description']);
        unset($fillable['name']);
        return $fillable;
    }

    private function tenantSetupCompleted($tenantId)
    {
        Tenant::where('id', $tenantId)->update([
            'setup_complete_flag' => true
        ]);
    }
}
