<?php

namespace App\Http\Controllers\Tenancy;

use App\Enums\Address\Addressable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\SetupRequest;
use App\Models\Tenant;
use App\Services\Contact\AddressService;


class SetupController extends Controller
{
    protected $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    public function create()
    {
        try {
            $tenant = Tenant::findOrFail(base64_decode(request()->tid));
            return view('auth.setup-inventory', compact('tenant'));
        } catch (\Exception $exception) {
            abort(401);
        }
    }

    public function store(SetupRequest $request)
    {
        try {
            $storable = $request->validated();

            $this->addressService->create($request->tenant_id, Addressable::TENANT, $storable);

            Tenant::find($request->tenant_id)->update([
                'setup_complete_flag' => true,
                'country_of_operation' => ucfirst($request->operation_country),
                'currency_of_operation' => ucwords($request->operation_currency),
                'tax_file_number' => $request->get('tfn', null)
            ]);

            return redirect('/@/dashboard');
        } catch (\Exception $exception) {
            return redirect('/');
        }
    }
}
