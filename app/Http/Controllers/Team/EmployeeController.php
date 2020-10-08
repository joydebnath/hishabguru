<?php

namespace App\Http\Controllers\Team;

use App\Enums\Contact\ContactType;
use App\Filters\Team\EmployeeFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Team\EmployeeRequest;
use App\Http\Resources\Team\EmployeeCollection;
use App\Models\Contact;
use App\Services\Contact\ContactService;
use Exception;

class EmployeeController extends Controller
{
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function index(EmployeeFilter $filters)
    {
        try {
            return new EmployeeCollection(
                Contact::filter($filters)
                    ->where('type', ContactType::EMPLOYEE)
                    ->with('emails', 'mobiles', 'addresses')
                    ->paginate()
            );
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], $exception->getCode());
        }
    }

    public function store(EmployeeRequest $request)
    {
        return $request;
    }

    public function show(Contact $contact)
    {
        //
    }

    public function update(EmployeeRequest $request, Contact $contact)
    {
        //
    }

    public function destroy($contactId)
    {
        try {
            Contact::find($contactId)->delete();
            return response(['message' => 'Employee is deleted!']);
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], $exception->getCode());
        }
    }
}
