<?php

namespace App\Http\Controllers\Contact;

use App\Enums\Address\AddressType;
use App\Enums\Contact\ContactType;
use App\Filters\Contact\ClientFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\ClientRequest;
use App\Http\Resources\Contact\Client;
use App\Http\Resources\Contact\ClientCollection;
use App\Http\Resources\Contact\ClientResource;
use App\Models\Contact;
use App\Services\Contact\ContactService;
use Exception;

class ClientsController extends Controller
{
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function index(ClientFilter $filters)
    {
        try {
            return new ClientCollection(
                Contact::filter($filters)
                    ->where('type', ContactType::CLIENT)
                    ->with('emails', 'mobiles', 'addresses')
                    ->paginate()
            );
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function store(ClientRequest $request)
    {
        try {
            $storeable = $request->validated();
            $contact = $this->contactService->create($storeable, ContactType::CLIENT);
            return new Client($contact->fresh('emails', 'mobiles', 'addresses'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function show($contactId)
    {
        try {
            return new ClientResource(Contact::find($contactId)->load('contact_details', 'addresses'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function update(ClientRequest $request, $contactId)
    {
        try {
            $updateable = $request->validated();
            $contact = $this->contactService->update($contactId, $updateable, AddressType::HOME);
            return new Client($contact->fresh('emails', 'mobiles', 'addresses'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function destroy($contactId)
    {
        try {
            Contact::find($contactId)->delete();
            return response(['message' => 'Client is deleted!']);
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }
}
