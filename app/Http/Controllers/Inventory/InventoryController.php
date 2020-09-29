<?php

namespace App\Http\Controllers\Inventory;

use App\Enums\Address\Addressable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\InventoryRequest;
use App\Services\Contact\AddressService;
use App\Services\Inventory\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    protected $inventoryService, $addressService;

    public function __construct(InventoryService $inventoryService, AddressService $addressService)
    {
        $this->inventoryService = $inventoryService;
        $this->addressService = $addressService;
    }

    public function index()
    {
        //
    }

    public function store(InventoryRequest $request)
    {
        $storable = $this->getAddressStoreable($request);
        $site = $this->inventoryService->create([
            'name' => $request->get('name'),
            'description' => $request->get('description', null),
        ], $storable['tenant_id']);

        $this->addressService->create($site->id, Addressable::INVENTORY_SITE, $storable);
    }

    public function show($id)
    {

    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
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
}
