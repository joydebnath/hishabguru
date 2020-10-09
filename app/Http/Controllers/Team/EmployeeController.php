<?php

namespace App\Http\Controllers\Team;

use App\Enums\Address\AddressType;
use App\Enums\Contact\ContactType;
use App\Filters\Team\EmployeeFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Team\EmployeeRequest;
use App\Http\Resources\Team\Employee;
use App\Http\Resources\Team\EmployeeCollection;
use App\Http\Resources\Team\EmployeeFullResource;
use App\Models\Contact;
use App\Services\Contact\ContactService;
use App\Services\Contact\EmployeeDetailsService;
use Exception;

class EmployeeController extends Controller
{
    protected $contactService, $employeeDetailsService;

    public function __construct(ContactService $contactService, EmployeeDetailsService $employeeDetailsService)
    {
        $this->contactService = $contactService;
        $this->employeeDetailsService = $employeeDetailsService;
    }

    public function index(EmployeeFilter $filters)
    {
        try {
            return new EmployeeCollection(
                Contact::filter($filters)
                    ->where('type', ContactType::EMPLOYEE)
                    ->with('emails', 'mobiles', 'jobTitle', 'currentlyWorking', 'addresses')
                    ->paginate()
            );
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function store(EmployeeRequest $request)
    {
        try {
            $storeable = $request->validated();
            $contact = $this->contactService->create($storeable, ContactType::EMPLOYEE);
            $this->employeeDetailsService->create($contact->id, $storeable);

            return new Employee($contact->fresh('emails', 'mobiles', 'jobTitle', 'currentlyWorking', 'addresses'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function show($contact)
    {
        try {
            return new EmployeeFullResource(Contact::find($contact)->load('contact_details', 'addresses'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function update(EmployeeRequest $request, $contact)
    {
        try {
            $updateable = $request->validated();
            $contact = $this->contactService->update($contact, $updateable, AddressType::HOME);
            $this->employeeDetailsService->update($contact->id, $updateable);

            return new Employee($contact->fresh('emails', 'mobiles', 'jobTitle', 'currentlyWorking', 'addresses'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function destroy($contact)
    {
        try {
            Contact::find($contact)->delete();
            return response(['message' => 'Employee is deleted!']);
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }
}
