<?php

namespace App\Http\Controllers\Lookup;

use App\Enums\Contact\ContactType;
use App\Filters\Contact\ClientLookupFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\Contact\ClientLookup;
use App\Http\Resources\Contact\ClientLookupCollection;
use App\Models\Contact;
use App\Services\Contact\ContactService;
use Exception;
use Illuminate\Http\Request;

class ClientLookupController extends Controller
{
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function index(ClientLookupFilter $filters)
    {
        try {
            return new ClientLookupCollection(
                Contact::filter($filters)
                    ->where('type', ContactType::CLIENT)
                    ->with('emails', 'mobiles', 'addresses')
                    ->limit(15)
                    ->get()
            );
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $client = $this->contactService->create([
            'name' => $request->name,
            'note' => null,
            'tenant_id' => $request->tenant_id,
            'mobile' => $request->mobile
        ], ContactType::CLIENT);
        return new ClientLookup($client->load('emails', 'mobiles', 'addresses'));
    }
}
