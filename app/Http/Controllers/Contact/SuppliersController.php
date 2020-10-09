<?php

namespace App\Http\Controllers\Contact;

use App\Enums\Address\AddressType;
use App\Enums\Contact\ContactType;
use App\Filters\Contact\SupplierFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\SupplierRequest;
use App\Http\Resources\Contact\Supplier;
use App\Http\Resources\Contact\SupplierCollection;
use App\Http\Resources\Contact\SupplierResource;
use App\Models\Contact;
use App\Services\Contact\ContactService;
use Exception;

class SuppliersController extends Controller
{
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function index(SupplierFilter $filters)
    {
        try {
            return new SupplierCollection(
                Contact::filter($filters)
                    ->where('type', ContactType::SUPPLIER)
                    ->with('emails', 'mobiles', 'addresses')
                    ->paginate()
            );
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function store(SupplierRequest $request)
    {
        try {
            $storeable = $request->validated();
            $contact = $this->contactService->create($storeable, ContactType::SUPPLIER);
            return new Supplier($contact->fresh('contact_details', 'addresses'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function show($contactId)
    {
        try {
            return new SupplierResource(Contact::find($contactId)->load('contact_details', 'addresses', 'child_contacts.contact_details'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function update(SupplierRequest $request, $contactId)
    {
        try {
            $updateable = $request->validated();
            $contact = $this->contactService->update($contactId, $updateable, AddressType::HQ);
            return new Supplier($contact->fresh('contact_details', 'addresses'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function destroy($contactId)
    {
        try {
            Contact::find($contactId)->delete();
            return response(['message' => 'Supplier is deleted!']);
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }
}
